@extends('layouts.backend')

@section('content')
<div class="container-fluid p-0">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle">Analytics Dashboard</h1>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h5 class="card-title">User Activity</h5>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="userActivityChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Top 5 Borrowed Books</h5>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="borrowedBooksChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Forum Engagement</h5>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="engagementChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-header">
                        <h5 class="card-title">Top Search Terms</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="searchChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Activity
    const userActivityChart = new Chart(document.getElementById('userActivityChart'), {
        type: 'bar',
        data: {
            labels: ['Today', 'Last 7 Days', 'Last 30 Days'],
            datasets: [{
                label: 'Visitors',
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
@endpush