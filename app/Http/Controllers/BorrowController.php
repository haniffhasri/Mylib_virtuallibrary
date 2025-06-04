<?php

namespace App\Http\Controllers;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use Carbon\Carbon;


class BorrowController extends Controller
{
    public function index(){
        $userId = Auth::id();
        $borrowed_book = Borrow::with('book')->where('user_id', $userId)->where('is_active', true)->get();
        return view('borrow.index', ['borrow' => $borrowed_book]);
    }

    public function show(Request $request){
        $sort = $request->query('sort', 'latest');

        $borrow = Borrow::when($sort === 'latest', function ($query) {
                    return $query->orderBy('created_at', 'desc');
                })
                ->when($sort === 'oldest', function ($query) {
                    return $query->orderBy('created_at', 'asc');
                })
                ->paginate(10)
                ->withQueryString();

        return view('admin.borrow', compact('borrow'));
    }

    public function borrow_book($id){
        $book = Book::find($id);
        $books_id = $book->id;

        $borrow = new Borrow;
        $borrow->book_id = $books_id;
        $borrow->user_id = Auth::user()->id;

        $borrow->due_date = Carbon::now()->addDays(10);

        $borrow->save();

        return redirect('/borrow')->with('message','Borrow Successfully!');
    }

    

    public function delete($id){
        $borrow = Borrow::find($id);
        $borrow->is_active = false;
        $borrow->save();
        return redirect()->back();
    }
}
