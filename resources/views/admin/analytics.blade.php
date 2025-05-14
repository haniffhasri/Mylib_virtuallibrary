@extends('layouts.backend')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Analytics Dashboard</h2>

    {{-- User Activity Chart --}}
    <div class="card mb-4">
        <div class="card-header">User Activity</div>
        <div class="card-body">
            <canvas id="userActivityChart" height="100"></canvas>
        </div>
    </div>

    {{-- Most Borrowed Books --}}
    <div class="card mb-4">
        <div class="card-header">Top 5 Borrowed Books</div>
        <div class="card-body">
            <canvas id="borrowedBooksChart" height="100"></canvas>
        </div>
    </div>

    {{-- Forum Engagement --}}
    <div class="card mb-4">
        <div class="card-header">Forum Engagement</div>
        <div class="card-body">
            <canvas id="engagementChart" height="100"></canvas>
        </div>
    </div>

    {{-- Top Search Terms --}}
    <div class="card mb-4">
        <div class="card-header">Top Search Terms</div>
        <div class="card-body">
            <canvas id="searchChart" height="100"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Activity
    const userActivityChart = new Chart(document.getElementById('userActivityChart'), {
        type: 'bar',
        data: {
            labels: ['Today', 'Last 7 Days', 'Last 30 Days'],
            datasets: [{
                label: 'New Users',
                data: [@json($daily_visits), @json($weekly_visits), @json($monthly_visits)],
                backgroundColor: ['#4caf50', '#2196f3', '#ff9800']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } }
        }
    });

    // Most Borrowed Books
    const topBooks = @json($most_borrowed_books);
    const bookLabels = topBooks.map(b => b.book.book_title);
    const bookCounts = topBooks.map(b => b.total);

    new Chart(document.getElementById('borrowedBooksChart'), {
        type: 'bar',
        data: {
            labels: bookLabels,
            datasets: [{
                label: 'Times Borrowed',
                data: bookCounts,
                backgroundColor: '#03a9f4'
            }]
        },
        options: { responsive: true }
    });

    // Forum Engagement
    new Chart(document.getElementById('engagementChart'), {
        type: 'doughnut',
        data: {
            labels: ['Forums', 'Threads', 'Comments'],
            datasets: [{
                data: [@json($forum_count), @json($thread_count), @json($comment_count)],
                backgroundColor: ['#e91e63', '#9c27b0', '#00bcd4']
            }]
        },
        options: { responsive: true }
    });

    // Top Search Terms
    const topSearches = @json($top_searches);
    const searchLabels = topSearches.map(s => s.term);
    const searchCounts = topSearches.map(s => s.total);

    new Chart(document.getElementById('searchChart'), {
        type: 'bar',
        data: {
            labels: searchLabels,
            datasets: [{
                label: 'Search Frequency',
                data: searchCounts,
                backgroundColor: '#673ab7'
            }]
        },
        options: { responsive: true }
    });
</script>
@endsection
