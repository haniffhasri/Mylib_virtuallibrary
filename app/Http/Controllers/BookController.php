<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use App\Models\Rating;
use App\Models\SearchLog;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewBookNotification;
use Illuminate\Validation\ValidationException;
use App\Services\ImageKitService;

class BookController extends Controller
{
    protected $imageKit;

    public function __construct(ImageKitService $imageKit)
    {
        $this->imageKit = $imageKit;
    }

    public function index(Request $request)
    {
        $sort = $request->query('sort', 'latest');

        $books = Book::when($sort === 'latest', function ($query) {
                    return $query->orderBy('created_at', 'desc');
                })
                ->when($sort === 'oldest', function ($query) {
                    return $query->orderBy('created_at', 'asc');
                })
                ->paginate(10)
                ->withQueryString();

        $activeBorrowedBooks = collect(); 
        if (Auth::check()) {
            $activeBorrowedBooks = Borrow::where('user_id', Auth::id())
                ->where('is_active', true) 
                ->pluck('book_id');
        }

        $authors = Book::select('author')->distinct()->pluck('author');
        $genres = Book::select('genre')->distinct()->pluck('genre');

        return view('book.index', [
            'book' => $books,
            'borrowedBookIds' => $activeBorrowedBooks,
            'authors' => $authors,
            'genres' => $genres,
        ]);
    }

    public function show($id)
    {
        $book = Book::findOrFail($id);
        $borrow = Borrow::with('book')->get();
        $user = User::select('name')->get(); 

        $activeBorrowedBooks = collect();
        if (Auth::check()) {
            $activeBorrowedBooks = Borrow::where('user_id', Auth::id())
                ->where('is_active', true)
                ->pluck('book_id');
        }

        return view('book.show', [
            'book' => $book,
            'borrow' => $borrow,
            'user' => $user,
            'borrowedBookIds' => $activeBorrowedBooks
        ]);
    }

    public function create()
    {
        return view('book.insert');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
    
        // Delete media file from ImageKit if it exists
        if ($book->media_file_id) {
            $this->imageKit->delete($book->media_file_id);
        }
    
        // Delete image file from ImageKit if it exists
        if ($book->image_file_id) {
            $this->imageKit->delete($book->image_file_id);
        }
    
        // Now delete the book record itself
        $book->delete();
    
        return redirect()->back()->with('success', 'Book deleted successfully');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);  
        return view('book.edit', compact('book'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'book_title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'genre' => 'required|string|max:100',
                'format' => 'required|in:pdf,audio',
                'book_publication_date' => 'required|date',
                'media_path' => 'nullable|mimes:pdf,mp3|max:20480',
                'image_path' => 'nullable|image|max:2048',
            ]);

            $book = Book::findOrFail($id);
        
            $book->book_title = $request->book_title;
            $book->author = $request->author;
            $book->book_description = $request->book_description;
            $book->genre = $request->genre;
            $book->format = $request->format;
            $book->book_publication_date = $request->book_publication_date;
        
            // Delete media if requested
            if ($request->delete_media == '1' && $book->media_file_id) {
                $this->imageKit->delete($book->media_file_id);
                $book->media_path = null;
                $book->media_file_id = null;
            }
        
            // Delete image if requested
            if ($request->delete_image == '1' && $book->image_file_id) {
                $this->imageKit->delete($book->image_file_id);
                $book->image_path = null;
                $book->image_file_id = null;
            }
        
            // Upload new media if any
            if ($request->hasFile('media_path')) {
                // Delete old media first if exists
                if ($book->media_file_id) {
                    $this->imageKit->delete($book->media_file_id);
                }
                
                $uploadedMedia = $this->imageKit->upload(
                    $request->file('media_path'),
                    'book_media_' . $book->id . '_' . time(),
                    'library/media'
                );
                
                if ($uploadedMedia) {
                    $book->media_path = $uploadedMedia->url;
                    $book->media_file_id = $uploadedMedia->fileId;
                }
            }
        
            // Upload new image if any
            if ($request->hasFile('image_path')) {
                // Delete old image first if exists
                if ($book->image_file_id) {
                    $this->imageKit->delete($book->image_file_id);
                }
                
                $uploadedImage = $this->imageKit->upload(
                    $request->file('image_path'),
                    'book_image_' . $book->id . '_' . time(),
                    'library/images'
                );
                
                if ($uploadedImage) {
                    $book->image_path = $uploadedImage->url;
                    $book->image_file_id = $uploadedImage->fileId;
                }
            }
        
            // Set status based on whether media_path exists
            $book->status = $book->media_path ? true : false;
        
            $book->save();
        
            return redirect('/book')->with('success', 'Book updated successfully!');
        } catch(Exception $e) {
            Log::error('Book update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update the book.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'book_title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'genre' => 'required|string|max:100',
                'format' => 'required|in:pdf,audio',
                'call_number' => 'required|string|unique:books,call_number',
                'item_id' => 'required|string|unique:books,item_id',
                'isbn' => 'required|string|unique:books,isbn',
                'book_publication_date' => 'required|date',
                'media_path' => 'nullable|mimes:pdf,mp3|max:20480',
                'image_path' => 'nullable|image|max:2048',
            ]);

            $book = new Book();
            $book->book_title = $request->book_title;
            $book->author = $request->author;
            $book->book_description = $request->book_description;
            $book->genre = $request->genre;
            $book->format = $request->format;
            $book->call_number = $request->call_number;
            $book->item_id = $request->item_id;
            $book->isbn = $request->isbn;
            $book->initial_cataloguer = Auth::user()->username;
            $book->book_publication_date = $request->book_publication_date;

            // Upload media file if exists
            if ($request->hasFile('media_path')) {
                $uploadedMedia = $this->imageKit->upload(
                    $request->file('media_path'),
                    'book_media_' . time(),
                    'library/media'
                );
                
                if ($uploadedMedia) {
                    $book->media_path = $uploadedMedia->url;
                    $book->media_file_id = $uploadedMedia->fileId;
                    $book->status = true;
                }
            }
        
            // Upload image file if exists
            if ($request->hasFile('image_path')) {
                $uploadedImage = $this->imageKit->upload(
                    $request->file('image_path'),
                    'book_image_' . time(),
                    'library/images'
                );
                
                if ($uploadedImage) {
                    $book->image_path = $uploadedImage->url;
                    $book->image_file_id = $uploadedImage->fileId;
                }
            }

            $book->save();
            
            // Notify users
            foreach (User::where('usertype','user')->get() as $user) {
                $user->notify(new NewBookNotification($book));
            }

            return redirect('/book')->with('success', 'Book added successfully!');
        } catch (ValidationException $e) {
            Log::error('Book store validation error: ' . json_encode($e->errors()));
            return redirect()->back()
                            ->withErrors($e->validator)
                            ->withInput();
        } catch (Exception $e) {
            Log::error('Book store general error: ' . $e->getMessage());
            return redirect()->back()
                            ->with('error', 'An unexpected error occurred. Please try again.')
                            ->withInput();
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $author = $request->input('author');
        $genre = $request->input('genre');
        $format = $request->input('format');
        $status = $request->input('status');

        $bookQuery = Book::query();

        if ($query) {
            $bookQuery->whereRaw("search_vector @@ websearch_to_tsquery('english', ?)", [$query])
                    ->orderByRaw("ts_rank(search_vector, websearch_to_tsquery('english', ?)) DESC", [$query]);
        }

        if ($author) {
            $bookQuery->where('author', $author);
        }

        if ($genre) {
            $bookQuery->where('genre', $genre);
        }

        if ($format) {
            $bookQuery->where('format', $format);
        }

        if ($status !== null) {
            $bookQuery->where('status', $status === 'true');
        }

        $books = $bookQuery->paginate(6)->withQueryString();

        if ($query && $books->isEmpty()) {
            $fallbackQuery = Book::query()
                ->where('book_title', 'ILIKE', '%' . $query . '%')
                ->orWhere('book_description', 'ILIKE', '%' . $query . '%')
                ->orWhere('author', 'ILIKE', '%' . $query . '%');

            if ($author) {
                $fallbackQuery->where('author', $author);
            }

            if ($genre) {
                $fallbackQuery->where('genre', $genre);
            }

            if ($format) {
                $fallbackQuery->where('format', $format);
            }

            if ($status !== null) {
                $fallbackQuery->where('status', $status === 'true');
            }

            $books = $fallbackQuery->paginate(6)->withQueryString();
        }

        $activeBorrowedBooks = collect();
        if (Auth::check()) {
            $activeBorrowedBooks = Borrow::where('user_id', Auth::id())
                ->where('is_active', true)
                ->pluck('book_id');
        }

        $authors = Book::select('author')->distinct()->pluck('author');
        $genres = Book::select('genre')->distinct()->pluck('genre');

        if ($query) {
            SearchLog::create([
                'term' => $query,
                'results' => $books->total(),
                'ip' => $request->ip(),
                'user_id' => Auth::id(),
                'type' => 'book',
            ]);
        }

        return view('book.index', [
            'book' => $books,
            'query' => $query,
            'borrowedBookIds' => $activeBorrowedBooks,
            'genres' => $genres,
            'authors' => $authors,
        ]);
    }

    public function rate(Request $request, $bookId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $book = Book::findOrFail($bookId);

        Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $book->id],
            ['rating' => $request->rating]
        );

        return redirect()->back()->with('success', 'Rating submitted!');
    }
}