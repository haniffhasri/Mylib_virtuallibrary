<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Comment;
use App\Notifications\UserTagged;
// use Dom\Comment;
use Illuminate\Support\Facades\Auth;
class CommentController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer',
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $model = app($request->commentable_type)::findOrFail($request->commentable_id);

        $comment = $model->comments()->create([
            'user_id' => Auth::id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);

        // Detect @tags in comment body
        preg_match_all('/@([\w\-]+)/', $comment->body, $matches);

        $usernames = $matches[1]; 
        $taggedUsers = User::whereIn('name', $usernames)->get();

        foreach ($taggedUsers as $user) {
            if ($user->id !== Auth::id()) {
                $user->notify(new UserTagged($comment));
            }
        }

        return redirect()->back();
    }


    public function update($id, Request $request){
        $comment = Comment::findOrFail($id);
        $comment->body = $request->body;

        $comment->save();

        return redirect()->back()->with('success', 'Comment updated');
    }

    public function delete($id){
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted');
    }

    protected function handleTagging($comment, $body){
        preg_match_all('/@([\w\s]+)/', $body, $matches);

        if ($matches && !empty($matches[1])) {
            foreach ($matches[1] as $name) {
                $user = User::where('name', $name)->first();
                if ($user && $user->id !== Auth::id()) {
                    $user->notify(new UserTagged($comment));
                }
            }
        }
    }
}
