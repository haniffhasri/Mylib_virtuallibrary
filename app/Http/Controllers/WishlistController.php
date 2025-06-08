<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index(){
        $wishlists = Wishlist::with('user')->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function delete($id){
        $wishlists = Wishlist::findOrFail($id);
        $wishlists->delete();
        return redirect('/wishlist');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Wishlist::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'isbn' => $request->isbn,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Book wished successfully!');
    }
}
