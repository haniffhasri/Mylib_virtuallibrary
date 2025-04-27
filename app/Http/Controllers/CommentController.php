<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function store(Request $request, $bookId){
        $request->validate(['body' => 'required']);

        $body = $request->body;

        // Find all @mentions using regex
        preg_match_all('/@([\w]+)/', $body, $matches);
        $usernames = $matches[1]; // Array of usernames mentioned

        foreach ($usernames as $username) {
            $user = \App\Models\User::where('name', $username)->first();
            if ($user) {
                $mentionTag = '@' . $username;
                $profileLink = '<a href="' . route('user.profile', $user->id) . '">@' . $username . '</a>';
                $body = str_replace($mentionTag, $profileLink, $body);
            }
        }
        
        Comment::create([
            'user_id' => Auth::user()->id,
            'book_id' => $bookId,
            'body' => $request->body,
            'parent_id' => $request->parent_id // this can be null for top-level comments
        ]);

        return back();
    }

}
