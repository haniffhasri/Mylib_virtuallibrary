<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index(){
        $book = Book::orderBy('created_at','desc')->paginate(6);
        $borrow = Borrow::where('user_id', Auth::id())->pluck('book_id');
        return view('book.index', compact('book', 'borrow'));
    }
    
    public function show($id){
        $book = Book::findOrFail($id);
        $borrow = Borrow::with('book')->get();

        return view('book.show', compact('book', 'borrow'), ['book'=> $book]);
    }


    public function create(){
        return view('book.insertion');
    }

    public function destroy($id){
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->back();
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
        $book->status = $request->status;
        $book->book_publication_date = $request->book_publication_date;
        // Handle PDF upload
        $pdf_path = $request->file('pdf_path');
        if ($pdf_path) {
            // Delete old PDF if it exists
            if ($book->pdf_path) {
                $old_pdf_path = public_path('pdfs/' . $book->pdf_path);
                if (file_exists($old_pdf_path)) {
                    unlink($old_pdf_path);
                }
            }
            
            // Save new PDF
            $pdf_path_name = time() . '.' . $pdf_path->getClientOriginalExtension();
            $request->pdf_path->move('pdfs', $pdf_path_name);
            $book->pdf_path = $pdf_path_name;
        }

        // Handle image upload
        $image_path = $request->file('image_path');
        if ($image_path) {
            // Delete old image if it exists
            if ($book->image_path) {
                $old_image_path = public_path('pdfs/' . $book->image_path);
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
            
            // Save new image
            $image_path_name = time() . '.' . $image_path->getClientOriginalExtension();
            $request->image_path->move('pdfs', $image_path_name);
            $book->image_path = $image_path_name;
        }

        $book->save();
        return redirect('/book');
    }

    public function store(Request $request){
        $book = new Book();
        $book->book_title = $request->book_title;
        $book->author = $request->author;
        $book->book_description = $request->book_description;
        $book->genre = $request->genre;
        $book->format = $request->format;
        $book->status = $request->status;
        $book->book_publication_date = $request->book_publication_date;
        $pdf_path = $request->file('pdf_path'); // Use the `file()` method
        if ($pdf_path) {
            $pdf_path_name = time() . '.' . $pdf_path->getClientOriginalExtension();
            $request->pdf_path->move('pdfs',$pdf_path_name);
            $book->pdf_path = $pdf_path_name;
        }

        $image_path = $request->file('image_path');
        if ($image_path) {
            $image_path_name = time() . '.' . $image_path->getClientOriginalExtension();
            $request->image_path->move('pdfs',$image_path_name);
            $book->image_path = $image_path_name;
        }

        $book->save();

        return redirect('/book');
    }

    
}
