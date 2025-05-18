<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Forum;

class ForumController extends Controller
{
    public function index(Request $request){
        $sort = $request->query('sort', 'latest');

        $forum = Forum::when($sort === 'latest', function ($query) {
            return $query->orderBy('created_at', 'desc');
        })
        ->when($sort === 'oldest', function ($query) {
            return $query->orderBy('created_at', 'asc');
        })
        ->paginate(10)
        ->withQueryString();
        
        return view('forum.index', compact('forum'));
    }

    public function create(){
        return view ('forum.create');
    }

    public function show($slug){
        $forum = Forum::where('slug', $slug)->firstOrFail();
        return view('forum.show', compact('forum'));
    }

    public function store(Request $request){
        $request->validate([
            'forum_title' => 'required|string|max:255',
            'forum_description' => 'nullable|string',
        ]);

        Forum::create([
            'forum_title' => $request->forum_title,
            'forum_description' => $request->forum_description,
            'slug' => Str::slug($request->forum_title),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('forum.index');
    }
}
