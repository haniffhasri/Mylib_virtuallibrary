<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Forum;
use App\Models\Thread;
use App\Models\Visitor;
use App\Models\Comment;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    public function index(){
        $today = Carbon::today();
        $weekAgo = Carbon::now()->subWeek();
        $monthAgo = Carbon::now()->subMonth();

        return view('admin.analytics', [
            // User Activity
            'daily_visits' => Visitor::whereDate('created_at', $today)->count(),
            'weekly_visits' => Visitor::whereBetween('created_at', [$weekAgo, now()])->count(),
            'monthly_visits' => Visitor::whereBetween('created_at', [$monthAgo, now()])->count(),
            // 'registration_users' => Visitor::where('created_at', '>=', $monthAgo)->count(),

            // Content Usage
            'most_borrowed_books' => Borrow::select('book_id', DB::raw('count(*) as total'))
                ->groupBy('book_id')
                ->orderByDesc('total')
                ->with('book') // Ensure 'book' relationship exists in Borrow model
                ->take(5)
                ->get(),
            'unavailable_books' => Book::where('status', 'false')->count(),
            'available_books' => Book::where('status', 'true')->count(),

            // Forums and Engagement
            'forum_count' => Forum::count(),
            'thread_count' => Thread::count(),
            'comment_count' => DB::table('comments')->count(),

            // Search
            'top_searches' => DB::table('search_logs')
                ->select('term', DB::raw('count(*) as total'))
                ->groupBy('term')
                ->orderByDesc('total')
                ->limit(10)
                ->get(),
            'no_result_searches' => DB::table('search_logs')->where('results', 0)->count(),
        ]);
    }

}
