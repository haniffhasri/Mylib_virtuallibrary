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
        $user = Auth::user();

        // Count active borrows for the current user
        $activeBorrowCount = Borrow::where('user_id', $user->id)
                                    ->where('is_active', true)
                                    ->count();

        if ($activeBorrowCount >= 5) {
            return redirect('/borrow')->with('error', 'You can only borrow up to 5 books at a time.');
        }

        $book = Book::find($id);

        if (!$book) {
            return redirect('/borrow')->with('error', 'Book not found.');
        }

        $borrow = new Borrow;
        $borrow->book_id = $book->id;
        $borrow->user_id = $user->id;
        $borrow->due_date = Carbon::now()->addDays(10);
        $borrow->is_active = true;

        $borrow->save();

        return redirect('/borrow')->with('message', 'Borrowed Successfully!');
    }

    public function delete($id){
        $borrow = Borrow::find($id);
        $borrow->is_active = false;
        $borrow->save();
        return redirect()->back();
    }
}
