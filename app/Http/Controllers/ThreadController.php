<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Forum;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\SearchLog;

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

    private function getDateRange($range){
        $now = Carbon::now();

        switch ($range) {
            case 'today':
                return [Carbon::today(), $now];
            case 'this_week':
                return [Carbon::now()->startOfWeek(), $now];
            case 'this_month':
                return [Carbon::now()->startOfMonth(), $now];
            case 'this_year':
                return [Carbon::now()->startOfYear(), $now];
            default:
                return [Carbon::minValue(), $now]; // fallback to all time
        }
    }

    public function search(Request $request){
        $query = $request->input('q');
        $user = $request->input('user');
        $created_at = $request->input('created_at'); 

        $thread = Thread::query();

        if ($user) {
            $thread->whereHas('user', function ($q) use ($user) {
                $q->where('username', 'ILIKE', '%' . $user . '%');
            });
        }

        if ($created_at) {
            $thread->whereBetween('created_at', $this->getDateRange($created_at));
        }

        $threads = $thread->paginate(6)->withQueryString();

        if ($query && $threads->isEmpty()) {
            $fallbackQuery = Forum::query()
                ->where('forum_title', 'ILIKE', '%' . $query . '%')
                ->orWhere('forum_description', 'ILIKE', '%' . $query . '%');

            if ($user) {
                $fallbackQuery->orWhereHas('user', function ($q) use ($user) {
                    $q->where('username', 'ILIKE', '%' . $user . '%');
                });
            }

            $threads = $fallbackQuery->paginate(6)->withQueryString();
        }

        // Log search
        if ($query) {
            SearchLog::create([
                'term' => $query,
                'results' => $threads->total(),
                'ip' => $request->ip(),
                'user_id' => Auth::id(),
                'type' => 'thread',
            ]);
        }

        return view('forum.show', [
            'forum' => $threads,
            'user' => $user,
            'created_at' => $created_at,
        ]);
    }
}
