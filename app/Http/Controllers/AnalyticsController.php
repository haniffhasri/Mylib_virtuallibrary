<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Forum;
use App\Models\Thread;
use App\Models\Visitor;
use App\Models\Comment;
use Barryvdh\DomPDF\Facade\Pdf;

class AnalyticsController extends Controller
{
    public function index(){
        $today = Carbon::today();
        $weekAgo = Carbon::now()->subWeek();
        $monthAgo = Carbon::now()->subMonth();
        $searchTotal = DB::table('search_logs')->where('type', 'book')->count();
        $searchFailures = DB::table('search_logs')->where('type', 'book')->where('results', 0)->count();
        $searchFailureRate = $searchTotal > 0 ? round(($searchFailures / $searchTotal) * 100, 2) : 0;
        $visits = Visitor::whereNotNull('user_id')->get();
        if ($visits->isEmpty()) {
            $firstVisit = null;
            $lastVisit = null;
            $totalDays = 0;
            $totalVisits = 0;
            $average = 0;
        } else {
            $firstVisit = Carbon::parse($visits->first()->created_at);
            $lastVisit = Carbon::parse($visits->last()->created_at);
            $totalDays = $firstVisit->diffInDays($lastVisit) + 1;
            $totalVisits = $visits->count();
            $average = round($totalVisits / $totalDays, 2);
        }

        return view('admin.analytics', [
            // User Activity
            'daily_visits' => Visitor::whereDate('created_at', $today)->count(),
            'weekly_visits' => Visitor::whereBetween('created_at', [$weekAgo, now()])->count(),
            'monthly_visits' => Visitor::whereBetween('created_at', [$monthAgo, now()])->count(),
            'user_count' => User::count(),
            'active_user_count' => User::where('is_active', true)->count(),
           
            // registration
            'registration_users' => User::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as total")
                ->where('created_at', '>=', now()->subYear())
                ->groupBy('month')
                ->orderBy('month')
                ->get(),

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
            'comment_count' => Comment::where('commentable_type', 'App\Models\Thread')->count(),

            // Search
            'book_search_trends' => DB::table('search_logs')
                ->select('term', DB::raw('count(*) as total'))
                ->where('type', 'book')
                ->groupBy('term')
                ->orderByDesc('total')
                ->limit(10)
                ->get(),

            'book_no_result_searches' => DB::table('search_logs')
                ->where('type', 'book')
                ->where('results', 0)
                ->count(),

            // borrowing trends over time
            'borrowing_trends' => Borrow::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as total")
                ->where('created_at', '>=', now()->subYear())
                ->groupBy('month')
                ->orderBy('month')
                ->get(),
            
            // No result ratio
            'search_total' => $searchTotal,
            'total_book_searches' => $searchTotal,
            'search_failures' => $searchFailures,
            'search_failure_rate' => $searchFailureRate,

            'threads_count_per_forum' => Forum::withCount('threads')
                ->orderByDesc('threads_count')
                ->take(10)
                ->get(),

            // most commented thread
            'most_commented_threads' => Thread::whereHas('allComments', function ($q) {
                $q->where('commentable_type', Thread::class);
            })
            ->withCount('allComments')
            ->orderByDesc('all_comments_count')
            ->take(10)
            ->get(),

            // most book
            'most_commented_books' => Book::whereHas('allComments', function ($q) {
                $q->where('commentable_type', Book::class);
            })
            ->withCount('allComments')
            ->orderByDesc('all_comments_count')
            ->take(10)
            ->get(),

            // top borrower
            'top_borrowers' => Borrow::select('user_id', DB::raw('count(*) as total'))
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->with('user')
                ->take(5)
                ->get(),

            // avg user activity
            'average_activity' => $average,
        ]);
    }

    public function downloadReport(){
        $today = Carbon::today();
        $weekAgo = Carbon::now()->subWeek();
        $monthAgo = Carbon::now()->subMonth();

        $searchTotal = DB::table('search_logs')->where('type', 'book')->count();
        $searchFailures = DB::table('search_logs')->where('type', 'book')->where('results', 0)->count();
        $searchFailureRate = $searchTotal > 0 ? round(($searchFailures / $searchTotal) * 100, 2) : 0;

        $visits = Visitor::whereNotNull('user_id')->get();
        if ($visits->isEmpty()) {
            $average = 0;
        } else {
            $firstVisit = Carbon::parse($visits->first()->created_at);
            $lastVisit = Carbon::parse($visits->last()->created_at);
            $totalDays = $firstVisit->diffInDays($lastVisit) + 1;
            $totalVisits = $visits->count();
            $average = round($totalVisits / $totalDays, 2);
        }

        $data = [
            // User Activity
            'daily_visits' => Visitor::whereDate('created_at', $today)->count(),
            'weekly_visits' => Visitor::whereBetween('created_at', [$weekAgo, now()])->count(),
            'monthly_visits' => Visitor::whereBetween('created_at', [$monthAgo, now()])->count(),
            'user_count' => User::count(),
            'active_user_count' => User::where('is_active', true)->count(),

            // User registration trend
            'registration_users' => User::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as total")
                ->where('created_at', '>=', now()->subYear())
                ->groupBy('month')
                ->orderBy('month')
                ->get(),

            // Content usage
            'most_borrowed_books' => Borrow::select('book_id', DB::raw('count(*) as total'))
                ->groupBy('book_id')
                ->orderByDesc('total')
                ->with('book')
                ->take(5)
                ->get(),
            'unavailable_books' => Book::where('status', 'false')->count(),
            'available_books' => Book::where('status', 'true')->count(),

            // Forum & thread info
            'forum_count' => Forum::count(),
            'thread_count' => Thread::count(),
            'comment_count' => Comment::where('commentable_type', 'App\Models\Thread')->count(),
            'threads_count_per_forum' => Forum::withCount('threads')
                ->orderByDesc('threads_count')
                ->take(10)
                ->get(),

            // Most commented threads
            'most_commented_threads' => Thread::whereHas('allComments', function ($q) {
                $q->where('commentable_type', Thread::class);
            })
                ->withCount('allComments')
                ->orderByDesc('all_comments_count')
                ->take(10)
                ->get(),

            // Most commented books
            'most_commented_books' => Book::whereHas('allComments', function ($q) {
                $q->where('commentable_type', Book::class);
            })
                ->withCount('allComments')
                ->orderByDesc('all_comments_count')
                ->take(10)
                ->get(),

            // Top borrowers
            'top_borrowers' => Borrow::select('user_id', DB::raw('count(*) as total'))
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->with('user')
                ->take(5)
                ->get(),

            // Book search trends
            'book_search_trends' => DB::table('search_logs')
                ->select('term', DB::raw('count(*) as total'))
                ->where('type', 'book')
                ->groupBy('term')
                ->orderByDesc('total')
                ->limit(10)
                ->get(),

            // Book search failures
            'book_no_result_searches' => DB::table('search_logs')
                ->where('type', 'book')
                ->where('results', 0)
                ->count(),

            // Borrowing trends
            'borrowing_trends' => Borrow::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as total")
                ->where('created_at', '>=', now()->subYear())
                ->groupBy('month')
                ->orderBy('month')
                ->get(),

            // Search failure rate
            'search_total' => $searchTotal,
            'search_failures' => $searchFailures,
            'search_failure_rate' => $searchFailureRate,

            // Average activity
            'average_activity' => $average,
        ];

        $pdf = Pdf::loadView('admin.analytics_report_pdf', $data);
        return $pdf->download('analytics-report-' . now()->format('Y-m-d') . '.pdf');
    }

}
