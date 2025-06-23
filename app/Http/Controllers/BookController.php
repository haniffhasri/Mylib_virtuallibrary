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
use Illuminate\Support\Facades\Storage;

use function Pest\Laravel\delete;

class BookController extends Controller
{
    public function index(Request $request){
        $sort = $request->query('sort', 'latest');

        $books = Book::when($sort === 'latest', function ($query) {
                    return $query->orderBy('created_at', 'desc');
                })
                ->when($sort === 'oldest', function ($query) {
                    return $query->orderBy('created_at', 'asc');
                })
                ->paginate(8)
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

    public function show($id){
        $book = Book::findOrFail($id);
        $borrow = Borrow::with('book')->get();
        $user = User::select('name')->get(); 

        $activeBorrowedBooks = collect(); // default empty
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

    public function create(){
        return view('book.insert');
    }

    public function destroy($id){
        $book = Book::findOrFail($id);

        // Delete media file from S3 if it exists
        if ($book->media_path && Storage::disk('s3')->exists($book->media_path)) {
            Storage::disk('s3')->delete($book->media_path);
        }

        // Delete image file from S3 if it exists
        if ($book->image_path && Storage::disk('s3')->exists($book->image_path)) {
            Storage::disk('s3')->delete($book->image_path);
        }

        // Now delete the book record itself
        $book->delete();

        return redirect()->back()->with('success', 'Book and media deleted.');
    }

    public function edit($id){
        $book = Book::findOrFail($id);  
        return view('book.edit', compact('book'));
    }

    public function update(Request $request, $id){
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

            // Delete old media if requested
            if ($request->delete_media == '1' && $book->media_path) {
                if (Storage::disk('s3')->exists($book->media_path)) {
                    Storage::disk('s3')->delete($book->media_path);
                }
                $book->media_path = null;
            }

            // Delete old image if requested
            if ($request->delete_image == '1' && $book->image_path) {
                if (Storage::disk('s3')->exists($book->image_path)) {
                    Storage::disk('s3')->delete($book->image_path);
                }
                $book->image_path = null;
            }

            // Upload new media
            if ($request->hasFile('media_path')) {
                $media = $request->file('media_path');
                $mediaName = 'media/' . time() . '.' . $media->getClientOriginalExtension();
                Storage::disk('s3')->put($mediaName, file_get_contents($media));
                $book->media_path = $mediaName;
            }

            // Upload new image
            if ($request->hasFile('image_path')) {
                $image = $request->file('image_path');
                $imageName = 'images/' . time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('s3')->put($imageName, file_get_contents($image));
                $book->image_path = $imageName;
            }

            // Set status
            $book->status = $book->media_path ? true : false;

            $book->save();

            return redirect('/book')->with('success', 'Book updated!');
        } catch(Exception $e){
            Log::error('Book update error: ' . $e->getMessage());
            return back()->with('error', 'Failed to update the book.');
        }
    }

    public function store(Request $request){
        try{
            $validated = $request->validate([
                'book_title' => 'required|string|max:255',
                'author' => 'required|string|max:255',
                'genre' => 'required|string|max:100',
                'format' => 'required|in:pdf,audio',
                'call_number' => 'required|string|unique:books,call_number',
                'item_id' => 'required|string|unique:books,item_id',
                'isbn' => 'required|string|unique:books,isbn',
                'book_publication_date' => 'required|date',
                'media_path' => 'nullable|mimes:pdf,mp3|max:20480', // 20MB max
                'image_path' => 'nullable|image|max:2048', // 2MB max for image
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
            $book->status = $request->hasFile('media_path') ? true : false;

            if ($request->hasFile('media_path')) {
                $media = $request->file('media_path');
                $mediaName = 'media/' . time() . '.' . $media->getClientOriginalExtension();
                Storage::disk('s3')->put($mediaName, file_get_contents($media));
                $book->media_path = $mediaName;
            }
        
            if ($request->hasFile('image_path')) {
                $image = $request->file('image_path');
                $imageName = 'images/' . time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('s3')->put($imageName, file_get_contents($image));
                $book->image_path = $imageName;
            }

            $book->save();
            foreach (User::where('usertype','user')->get() as $user) {
                $user->notify(new NewBookNotification($book));
            }

            return redirect('/book');
        }  catch (ValidationException $e) {
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

    public function search(Request $request){
        $query = $request->input('q');
        $author = $request->input('author');
        $genre = $request->input('genre');
        $format = $request->input('format');
        $status = $request->input('status');

        $bookQuery = Book::query();

        // If there's a keyword, apply full-text search
        if ($query) {
            $bookQuery->whereRaw("search_vector @@ websearch_to_tsquery('english', ?)", [$query])
                    ->orderByRaw("ts_rank(search_vector, websearch_to_tsquery('english', ?)) DESC", [$query]);
        }

        // Apply filters (whether or not a keyword is present)
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

        // Clone the query before fallback in case search returns no result
        $books = $bookQuery->paginate(6)->withQueryString();

        // If the result is empty and a keyword was given, fallback to ILIKE search
        if ($query && $books->isEmpty()) {
            $fallbackQuery = Book::query()
                ->where('book_title', 'ILIKE', '%' . $query . '%')
                ->orWhere('book_description', 'ILIKE', '%' . $query . '%')
                ->orWhere('author', 'ILIKE', '%' . $query . '%');

            // Reapply filters for fallback
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

        // Borrowed book tracking
        $activeBorrowedBooks = collect();
        if (Auth::check()) {
            $activeBorrowedBooks = Borrow::where('user_id', Auth::id())
                ->where('is_active', true)
                ->pluck('book_id');
        }

        // Dropdown data
        $authors = Book::select('author')->distinct()->pluck('author');
        $genres = Book::select('genre')->distinct()->pluck('genre');

        // Log search
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

    public function rate(Request $request, $bookId){
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
