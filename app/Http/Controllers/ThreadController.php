<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ThreadController extends Controller
{
    public function store(Request $request, Forum $forum){
        $request->validate([
            'thread_title' => 'required|string',
            'thread_body' => 'required|string',
        ]);

        $forum->threads()->create([
            'thread_title' => $request->thread_title,
            'thread_body' => $request->thread_body,
            'user_id' => Auth::id(),
        ]);

        return back();
    }

    public function edit($id){
        $thread = Thread::findOrFail($id);
        return view('threads.edit', compact('thread'));
    }
    public function update($id, Request $request){
        $thread = Thread::findOrFail($id);
        $threadid = $thread->id;
        $thread->thread_title = $request->thread_title;
        $thread->thread_body = $request->thread_body;

        $thread->save();

        return redirect()->route('threads.show', $threadid)->with('success', 'Thread updated');
    }

    public function delete($id){
        $thread = Thread::findOrFail($id);

        $forumslug = $thread->forum->slug;
        $thread->delete();

        return redirect()->route('forum.show', $forumslug)->with('success', 'Thread deleted');
    }

    public function show($id){
        $thread = Thread::findOrFail($id);
        $user = User::select('name')->get();
        return view('threads.show', compact('thread', 'user'));
    }
}
