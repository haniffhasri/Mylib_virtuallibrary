<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;
use App\Models\SearchLog;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\delete;

class BookController extends Controller
{
    public function index(){
        $books = Book::orderBy('created_at', 'desc')->paginate(6);

        $activeBorrowedBooks = collect(); 
        if (Auth::check()) {
            $activeBorrowedBooks = Borrow::where('user_id', Auth::id())
                ->where('is_active', true) 
                ->pluck('book_id');
        }

        return view('book.index', [
            'book' => $books,
            'borrowedBookIds' => $activeBorrowedBooks
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
    
        // Delete media file if it exists
        if ($book->media_path) {
            $mediaPath = public_path('media/' . $book->media_path);
            if (file_exists($mediaPath)) {
                unlink($mediaPath);
            }
        }
    
        // Delete image file if it exists
        if ($book->image_path) {
            $imagePath = public_path('image/' . $book->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
    
        // Now delete the book record itself
        $book->delete();
    
        return redirect()->back()->with('success', 'Media deleted');
    }
    

    public function edit($id){
        $book = Book::findOrFail($id);  
        return view('book.edit', compact('book'));
    }

    public function update(Request $request, $id){
        $book = Book::findOrFail($id);
    
        $book->book_title = $request->book_title;
        $book->author = $request->author;
        $book->book_description = $request->book_description;
        $book->genre = $request->genre;
        $book->format = $request->format;
        $book->book_publication_date = $request->book_publication_date;
    
        // Delete media if requested
        if ($request->delete_media == '1' && $book->media_path) {
            $mediaPath = public_path('media/' . $book->media_path);
            if (file_exists($mediaPath)) {
                unlink($mediaPath);
            }
            $book->media_path = null;
        }
    
        // Delete image if requested
        if ($request->delete_image == '1' && $book->image_path) {
            $imagePath = public_path('image/' . $book->image_path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $book->image_path = null;
        }
    
        // Upload new media if any
        if ($request->hasFile('media_path')) {
            $media = $request->file('media_path');
            $mediaName = time() . '.' . $media->getClientOriginalExtension();
            $media->move('media', $mediaName);
            $book->media_path = $mediaName;
        }
    
        // Upload new image if any
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move('image', $imageName);
            $book->image_path = $imageName;
        }
    
        // Set status based on whether media_path exists
        $book->status = $book->media_path ? true : false;
    
        $book->save();
    
        return redirect('/book')->with('success', 'Book updated!');
    }
    
    

    public function store(Request $request){
        $request->validate([
            'book_title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:100',
            'format' => 'required|in:pdf,audio',
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
        $book->book_publication_date = $request->book_publication_date;
        $book->status = $request->hasFile('media_path') ? true : false;

        if ($request->hasFile('media_path')) {
            $media = $request->file('media_path');
            $mediaName = time() . '.' . $media->getClientOriginalExtension();
            $media->move(public_path('media'), $mediaName); // ✅ fixed this
            $book->media_path = $mediaName;
        }
    
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image'), $imageName);
            $book->image_path = $imageName;
        }

        $book->save();

        return redirect('/book');
    }

    public function search(Request $request){
        $query = $request->input('q');
    
        $book = Book::whereRaw("search_vector @@ websearch_to_tsquery('english', ?)", [$query])
            ->orderByRaw("ts_rank(search_vector, websearch_to_tsquery('english', ?)) DESC", [$query])
            ->paginate(6);
    
        if ($book->isEmpty()) {
            $book = Book::where('book_title', 'ILIKE', '%' . $query . '%')
                ->orWhere('book_description', 'ILIKE', '%' . $query . '%')
                ->paginate(6);
        }

        $activeBorrowedBooks = collect(); 
        if (Auth::check()) {
            $activeBorrowedBooks = Borrow::where('user_id', Auth::id())
                ->where('is_active', true) 
                ->pluck('book_id');
        }
    
        SearchLog::create([
            'term' => $query,
            'results' => $book->total(),
            'ip' => $request->ip(),
            'user_id' => Auth::id(),
        ]);
    
        return view('book.index', [
            'book' => $book,
            'query' => $query,
            'borrowedBookIds' => $activeBorrowedBooks
        ]);
    }
    

}
