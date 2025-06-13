@extends('layouts.backend')

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Header Section -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Analytics Dashboard</h1>
        <a href="{{ route('analytics.download') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
            Download Report
        </a>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-gray-200">
        <ul class="flex flex-wrap -mb-px list-none" id="analyticsTabs">
            <li class="mr-2">
                <button class="tab-button inline-block p-4 border-b-2 border-blue-600 rounded-t-lg text-blue-600 font-medium active" 
                        data-tab="website-performance">Website Performance</button>
            </li>
            <li class="mr-2">
                <button class="tab-button inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 font-medium" 
                        data-tab="user-segmentation">User Segmentation</button>
            </li>
            <li class="mr-2">
                <button class="tab-button inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 font-medium" 
                        data-tab="book-performance">Book Performance</button>
            </li>
            <li class="mr-2">
                <button class="tab-button inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 font-medium" 
                        data-tab="forum-analytics">Forum Analytics</button>
            </li>
        </ul>
    </div>

    <!-- Tab Content -->
    <div id="tab-content">

        <!-- Website Performance Tab -->
        <div class="tab-pane active" id="website-performance">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Visitor Activity -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Visitor Activity</h3>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="visitorActivityChart"></canvas>
                    </div>
                </div>

                <!-- Registration Trend -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Registration Trend</h3>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="RegistrationTrendChart"></canvas>
                    </div>
                </div>

                <!-- Search Performance -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Search Performance</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-md font-medium text-gray-700 mb-2">Top Search Terms</h4>
                            <div class="chart-container" style="position: relative; height: 250px;">
                                <canvas id="searchChart"></canvas>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-md font-medium text-gray-700 mb-2">Search Success Rate</h4>
                            <div class="chart-container" style="position: relative; height: 250px;">
                                <canvas id="failedSearchChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Segmentation Tab -->
        <div class="tab-pane hidden" id="user-segmentation">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Top Borrowers -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Borrowers</h3>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="topBorrowersChart"></canvas>
                    </div>
                </div>

                <!-- User Activity Over Time -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">User Activity Over Time</h3>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <!-- You could add a new chart here showing user activity patterns -->
                        <canvas id="userActivityPatternsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Performance Tab -->
        <div class="tab-pane hidden" id="book-performance">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Top Borrowed Books -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Borrowed Books</h3>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="borrowedBooksChart"></canvas>
                    </div>
                </div>

                <!-- Borrowing Trends -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Borrowing Trends</h3>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="borrowingTrendsChart"></canvas>
                    </div>
                </div>

                <!-- Most Commented Books -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Most Commented Books</h3>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="mostCommentedBooksChart"></canvas>
                    </div>
                </div>

                <!-- Book Categories Distribution -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Book Categories Distribution</h3>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <!-- You could add a new chart here showing book categories distribution -->
                        <canvas id="bookCategoriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forum Analytics Tab -->
        <div class="tab-pane hidden" id="forum-analytics">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Most Commented Threads -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Most Commented Threads</h3>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <canvas id="mostCommentedThreadsChart"></canvas>
                    </div>
                </div>

                <!-- Forum Activity Over Time -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Forum Activity Trend</h3>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <!-- You could add a new chart here showing forum activity over time -->
                        <canvas id="forumActivityTrendChart"></canvas>
                    </div>
                </div>

                <!-- Top Forum Contributors -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Top Forum Contributors</h3>
                    <div class="chart-container" style="position: relative; height: 300px;">
                        <!-- You could add a new chart here showing top forum contributors -->
                        <canvas id="topContributorsChart"></canvas>
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
    // Tab functionality
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-button');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs and panes
                document.querySelectorAll('.tab-button').forEach(t => {
                    t.classList.remove('active', 'border-blue-600', 'text-blue-600');
                    t.classList.add('border-transparent');
                });
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));
                
                // Add active class to clicked tab
                this.classList.add('active', 'border-blue-600', 'text-blue-600');
                this.classList.remove('border-transparent');
                
                // Show corresponding pane
                const paneId = this.getAttribute('data-tab');
                document.getElementById(paneId).classList.remove('hidden');
            });
        });

        // Chart configuration with blue theme
        const blueTheme = {
            backgroundColor: 'rgba(59, 130, 246, 0.7)',
            borderColor: 'rgba(59, 130, 246, 1)',
            hoverBackgroundColor: 'rgba(37, 99, 235, 1)',
            borderWidth: 1
        };

        // User Activity
        const visitorActivityChart = new Chart(document.getElementById('visitorActivityChart'), {
            type: 'bar',
            data: {
                labels: ['Today', 'Last 7 Days', 'Last 30 Days'],
                datasets: [{
                    label: 'Visitors',
                    data: [@json($daily_visits), @json($weekly_visits), @json($monthly_visits)],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(99, 102, 241, 0.7)',
                        'rgba(79, 70, 229, 0.7)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(99, 102, 241, 1)',
                        'rgba(79, 70, 229, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { 
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                }
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
                    ...blueTheme
                }]
            },
            options: { 
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { beginAtZero: true }
                }
            }
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
                    ...blueTheme
                }]
            },
            options: { 
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Registration Trend
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
                    ...blueTheme,
                    fill: false,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Borrowing Trend
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
                    ...blueTheme,
                    fill: false,
                    tension: 0.3
                }]
            },
            options: { 
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Failed Search Chart
        const failedSearches = @json($book_no_result_searches);
        const totalSearches = @json($total_book_searches);
        const successfulSearches = totalSearches - failedSearches;

        new Chart(document.getElementById('failedSearchChart'), {
            type: 'doughnut',
            data: {
                labels: ['Successful', 'No Results'],
                datasets: [{
                    data: [successfulSearches, failedSearches],
                    backgroundColor: ['rgba(59, 130, 246, 0.7)', 'rgba(239, 68, 68, 0.7)'],
                    borderColor: ['rgba(59, 130, 246, 1)', 'rgba(239, 68, 68, 1)'],
                    borderWidth: 1
                }]
            },
            options: { 
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Most Commented Threads
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
                    ...blueTheme
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false }
                },
                scales: { 
                    x: { beginAtZero: true }
                }
            }
        });

        // Most Commented Books
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
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false }
                },
                scales: { 
                    x: { beginAtZero: true }
                }
            }
        });

        // Top Borrowers
        const borrowers = @json($top_borrowers);
        const borrowerLabels = borrowers.map(b => b.user.name);
        const borrowerCounts = borrowers.map(b => b.total);

        new Chart(document.getElementById('topBorrowersChart'), {
            type: 'bar',
            data: {
                labels: borrowerLabels,
                datasets: [{
                    label: 'Borrows',
                    data: borrowerCounts,
                    backgroundColor: 'rgba(249, 115, 22, 0.7)',
                    borderColor: 'rgba(249, 115, 22, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: { 
                    y: { beginAtZero: true }
                }
            }
        });

        // Suggested new charts - you would need to implement these in your AnalyticsController
        // User Activity Patterns Chart
        new Chart(document.getElementById('userActivityPatternsChart'), {
            type: 'line',
            data: {
                labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'],
                datasets: [{
                    label: 'Active Users',
                    data: [10, 20, 150, 200, 180, 120],
                    ...blueTheme,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                }
            }
        });

        // Book Categories Distribution
        new Chart(document.getElementById('bookCategoriesChart'), {
            type: 'pie',
            data: {
                labels: ['Fiction', 'Non-Fiction', 'Science', 'History', 'Biography'],
                datasets: [{
                    data: [120, 80, 60, 40, 30],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',
                        'rgba(16, 185, 129, 0.7)',
                        'rgba(249, 115, 22, 0.7)',
                        'rgba(139, 92, 246, 0.7)',
                        'rgba(236, 72, 153, 0.7)'
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(16, 185, 129, 1)',
                        'rgba(249, 115, 22, 1)',
                        'rgba(139, 92, 246, 1)',
                        'rgba(236, 72, 153, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // Forum Activity Trend
        new Chart(document.getElementById('forumActivityTrendChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'New Threads',
                        data: [12, 19, 15, 20, 18, 22],
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderColor: 'rgba(59, 130, 246, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    },
                    {
                        label: 'Comments',
                        data: [45, 60, 55, 80, 75, 90],
                        backgroundColor: 'rgba(16, 185, 129, 0.2)',
                        borderColor: 'rgba(16, 185, 129, 1)',
                        borderWidth: 2,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Top Contributors Chart
        new Chart(document.getElementById('topContributorsChart'), {
            type: 'bar',
            data: {
                labels: ['User 1', 'User 2', 'User 3', 'User 4', 'User 5'],
                datasets: [{
                    label: 'Forum Contributions',
                    data: [120, 90, 75, 60, 45],
                    ...blueTheme
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                plugins: {
                    legend: { display: false }
                },
                scales: { 
                    x: { beginAtZero: true }
                }
            }
        });
    });
</script>
@endpush