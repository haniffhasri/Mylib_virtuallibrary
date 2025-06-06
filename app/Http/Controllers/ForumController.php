<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Forum;
use App\Models\SearchLog;
use Carbon\Carbon;

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

    public function show($slug, Request $request){
        $forum = Forum::where('slug', $slug)->firstOrFail();

        $query = $request->input('q');
        $sort = $request->query('sort', 'latest');
        $created_at = $request->input('created_at');
        $updated_at = $request->input('updated_at');

        $threads = $forum->threads()->with('user')
            ->when($query, function ($q) use ($query) {
                $q->where('thread_title', 'ILIKE', '%' . $query . '%')
                ->orWhere('thread_body', 'ILIKE', '%' . $query . '%');
            })
            ->when($created_at, function ($q) use ($created_at) {
                [$from, $to] = $this->getDateRange($created_at);
                $q->whereBetween('created_at', [$from, $to]);
            })
            ->when($sort === 'latest', fn($q) => $q->orderBy('updated_at', 'desc'))
            ->when($sort === 'oldest', fn($q) => $q->orderBy('updated_at', 'asc'))
            ->paginate(10)
            ->withQueryString();

        return view('forum.show', compact('forum', 'threads'));
    }

    private function getDateRange($range){
        $now = Carbon::now();
        return match($range) {
            'today' => [Carbon::today(), $now],
            'this_week' => [Carbon::now()->startOfWeek(), $now],
            'this_month' => [Carbon::now()->startOfMonth(), $now],
            'this_year' => [Carbon::now()->startOfYear(), $now],
            default => [Carbon::minValue(), $now]
        };
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

    public function search(Request $request){
        $query = $request->input('q');
        $user = $request->input('user');
        $created_at = $request->input('created_at'); 

        $forum = Forum::query();

        if ($query) {
            $forum->where(function ($q1) use ($query) {
                $q1->where('forum_title', 'ILIKE', '%' . $query . '%')
                    ->orWhere('forum_description', 'ILIKE', '%' . $query . '%');
            });
        }

        if ($user) {
            $forum->whereHas('user', function ($q) use ($user) {
                $q->where('username', 'ILIKE', '%' . $user . '%');
            });
        }

        if ($created_at) {
            $forum->whereBetween('created_at', $this->getDateRange($created_at));
        }

        $forums = $forum->paginate(6)->withQueryString();

        // Log search
        if ($query) {
            SearchLog::create([
                'term' => $query,
                'results' => $forums->total(),
                'ip' => $request->ip(),
                'user_id' => Auth::id(),
                'type' => 'forum',
            ]);
        }

        return view('forum.index', [
            'forum' => $forums,
            'user' => $user,
            'created_at' => $created_at,
        ]);
    }
}
