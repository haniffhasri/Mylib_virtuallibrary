@extends('layouts.backend')

@section('content')
<div class="container-fluid p-0">

    <div class="mb-3">
        <h4 class="h3 d-inline align-middle">Analytics Dashboard</h4>
    </div>
    <a href="{{ route('analytics.download') }}" class="btn btn-primary mb-3">Download Report</a>
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h4 class="card-title">Visitor Activity</h4>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="visitorActivityChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Top 5 Borrowed Books</h4>
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
                    <div class="card-header">
                        <h4 class="card-title">Top Search Terms</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="searchChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h4 class="card-title">Registration Trend</h4>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="RegistrationTrendChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card flex-fill w-100">
                <div class="card-header">
                    <h4 class="card-title">Borrowing Trends</h4>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="borrowingTrendsChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header"><h4 class="card-title">Search Success vs Failed</h4></div>
                <div class="card-body">
                    <canvas id="failedSearchChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header"><h4 class="card-title">Most Commented Threads</h4></div>
                <div class="card-body">
                    <canvas id="mostCommentedThreadsChart" height="100"></canvas>
                </div>
            </div>
        </div>


        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header"><h4 class="card-title">Most Commented Books</h4></div>
                <div class="card-body">
                    <canvas id="mostCommentedBooksChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header"><h4 class="card-title">Top Borrowers</h4></div>
                <div class="card-body">
                    <canvas id="topBorrowersChart" height="100"></canvas>
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
    const visitorActivityChart = new Chart(document.getElementById('visitorActivityChart'), {
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

    // Top Search Terms
    const topSearches = @json($book_search_trends);
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

    // registration trend
    const regData = @json($registration_users);
    const regLabels = regData.map(item => item.month);
    const regCounts = regData.map(item => item.total);

    new Chart(document.getElementById('RegistrationTrendChart'), {
        type: 'line',
        data: {
            labels: regLabels,
            datasets: [{
                label: 'Monthly Registrations',
                data: regCounts,
                borderColor: '#ff9800',
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // borrowing trend
    const borrowingTrends = @json($borrowing_trends);
    const borrowLabels = borrowingTrends.map(i => i.month);
    const borrowCounts = borrowingTrends.map(i => i.total);

    new Chart(document.getElementById('borrowingTrendsChart'), {
        type: 'line',
        data: {
            labels: borrowLabels,
            datasets: [{
                label: 'Borrows per Month',
                data: borrowCounts,
                borderColor: '#4caf50',
                fill: false,
                tension: 0.3
            }]
        },
        options: { responsive: true }
    });

    // failed search chart
    const failedSearches = @json($book_no_result_searches);
    const totalSearches = @json($total_book_searches);
    const successfulSearches = totalSearches - failedSearches;

    new Chart(document.getElementById('failedSearchChart'), {
        type: 'pie',
        data: {
            labels: ['Successful', 'No Results'],
            datasets: [{
                data: [successfulSearches, failedSearches],
                backgroundColor: ['#4caf50', '#f44336']
            }]
        },
        options: { responsive: true }
    });

    // most commented thread
    const threads = @json($most_commented_threads);
    const threadLabels = threads.map(t => t.thread_title);
    const threadComments = threads.map(t => t.comments_count);

    new Chart(document.getElementById('mostCommentedThreadsChart'), {
        type: 'bar',
        data: {
            labels: threadLabels,
            datasets: [{
                label: 'Comments',
                data: threadComments,
                backgroundColor: '#3f51b5'
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            scales: { x: { beginAtZero: true } }
        }
    });

    // most commented book
    const books = @json($most_commented_books);
    const commentedBookLabels = books.map(b => b.book_title);
    const commentedBookComments = books.map(b => b.comments_count);

    new Chart(document.getElementById('mostCommentedBooksChart'), {
        type: 'bar',
        data: {
            labels: commentedBookLabels,
            datasets: [{
                label: 'Comments',
                data: commentedBookComments,
                backgroundColor: '#009688'
            }]
        },
        options: {
            responsive: true,
            indexAxis: 'y',
            scales: { x: { beginAtZero: true } }
        }
    });

    // top Borrowers
    const borrowers = @json($top_borrowers);
    const borrowerLabels = borrowers.map(b => b.user.name);
    // const borrowCounts = borrowers.map(b => b.total);

    new Chart(document.getElementById('topBorrowersChart'), {
        type: 'bar',
        data: {
            labels: borrowerLabels,
            datasets: [{
                label: 'Borrows',
                data: borrowCounts,
                backgroundColor: '#ff9800'
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

</script>
@endpush