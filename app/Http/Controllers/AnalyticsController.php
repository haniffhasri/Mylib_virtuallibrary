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

        return view('admin.analytics', [
            // User Activity
            'daily_visits' => Visitor::whereDate('created_at', $today)->count(),
            'weekly_visits' => Visitor::whereBetween('created_at', [$weekAgo, now()])->count(),
            'monthly_visits' => Visitor::whereBetween('created_at', [$monthAgo, now()])->count(),
            
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
            'comment_count' => DB::table('comments')->count(),

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

            // most commented thread & book
            'most_commented_threads' => Thread::withCount('comments')
                ->orderByDesc('comments_count')
                ->take(5)
                ->get(),

            'most_commented_books' => Book::withCount('comments')
                ->orderByDesc('comments_count')
                ->take(5)
                ->get(),

            // top borrower
            'top_borrowers' => Borrow::select('user_id', DB::raw('count(*) as total'))
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->with('user')
                ->take(5)
                ->get(),
        ]);
    }

    public function downloadReport(){
        $today = Carbon::today();
        $weekAgo = Carbon::now()->subWeek();
        $monthAgo = Carbon::now()->subMonth();

        $searchTotal = DB::table('search_logs')->where('type', 'book')->count();
        $searchFailures = DB::table('search_logs')->where('type', 'book')->where('results', 0)->count();
        $searchFailureRate = $searchTotal > 0 ? round(($searchFailures / $searchTotal) * 100, 2) : 0;

        $data = [
            'daily_visits' => Visitor::whereDate('created_at', $today)->count(),
            'weekly_visits' => Visitor::whereBetween('created_at', [$weekAgo, now()])->count(),
            'monthly_visits' => Visitor::whereBetween('created_at', [$monthAgo, now()])->count(),
            'registration_users' => User::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as total")
                                        ->where('created_at', '>=', now()->subYear())
                                        ->groupBy('month')
                                        ->orderBy('month')
                                        ->get(),
            'most_borrowed_books' => Borrow::select('book_id', DB::raw('count(*) as total'))
                ->groupBy('book_id')
                ->orderByDesc('total')
                ->with('book')
                ->take(5)
                ->get(),
            'forum_count' => Forum::count(),
            'thread_count' => Thread::count(),
            'comment_count' => Comment::count(),
            'top_searches' => DB::table('search_logs')
                ->select('term', DB::raw('count(*) as total'))
                ->groupBy('term')
                ->orderByDesc('total')
                ->limit(10)
                ->get(),
            'most_commented_threads' => Thread::withCount('comments')
            ->orderByDesc('comments_count')
            ->take(5)
            ->get(),
            'most_commented_books' => Book::withCount('comments')
                ->orderByDesc('comments_count')
                ->take(5)
                ->get(),

            // Top Borrowers
            'top_borrowers' => Borrow::select('user_id', DB::raw('count(*) as total'))
                ->groupBy('user_id')
                ->orderByDesc('total')
                ->with('user')
                ->take(5)
                ->get(),

            'search_total' => $searchTotal,
            'search_failures' => $searchFailures,
            'search_failure_rate' => $searchFailureRate,
        ];

        $pdf = Pdf::loadView('admin.analytics_report_pdf', $data);
        return $pdf->download('analytics-report-' . now()->format('Y-m-d') . '.pdf');
    }

}
