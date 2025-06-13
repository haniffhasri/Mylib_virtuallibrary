@extends('layouts.backend')

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Analytics Dashboard</h1>
            <p class="text-gray-600">Insights and metrics about your library system</p>
        </div>
        <div class="flex gap-3">
            {{-- <div class="relative">
                <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Last 7 days</option>
                    <option>Last 30 days</option>
                    <option>Last 90 days</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div> --}}
            <a href="{{ route('analytics.download') }}" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
                Export
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Visitors</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($monthly_visits) }}</p>
                </div>
                <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2"><span class="text-green-500 font-medium">+12%</span> from last month</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Active Users</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($active_user_count) }}</p>
                </div>
                <div class="p-3 rounded-full bg-green-50 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2"><span class="text-green-500 font-medium">+8%</span> from last month</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Books Borrowed</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($borrowing_trends->sum('total')) }}</p>
                </div>
                <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2"><span class="text-green-500 font-medium">+15%</span> from last month</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-4 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Forum Activity</p>
                    <p class="text-2xl font-semibold text-gray-800">{{ number_format($comment_count) }}</p>
                </div>
                <div class="p-3 rounded-full bg-orange-50 text-orange-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-2"><span class="text-green-500 font-medium">+22%</span> from last month</p>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 overflow-x-auto pb-2 scrollbar-hide">
                <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-blue-500 text-blue-600" data-tab="website-performance">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z" />
                        </svg>
                        Website
                    </span>
                </button>
                <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="user-segmentation">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                        </svg>
                        Users
                    </span>
                </button>
                <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="book-performance">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                        </svg>
                        Books
                    </span>
                </button>
                <button class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="forum-analytics">
                    <span class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                        </svg>
                        Forum
                    </span>
                </button>
            </nav>
        </div>
    </div>

    <!-- Tab Content -->
    <div id="tab-content">

        <!-- Website Performance Tab -->
        <div class="tab-pane active" id="website-performance">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Visitor Activity -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Visitor Activity</h3>
                    </div>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="visitorActivityChart"></canvas>
                    </div>
                </div>

                <!-- Registration Trend -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Registration Trend</h3>
                        <div class="text-sm text-gray-500">Last 12 months</div>
                    </div>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="RegistrationTrendChart"></canvas>
                    </div>
                </div>

                <!-- Search Performance -->
                <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Search Performance</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-md font-medium text-gray-700">Top Search Terms</h4>
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $book_search_trends->count() }} terms</span>
                            </div>
                            <div class="chart-container" style="height: 250px;">
                                <canvas id="searchChart"></canvas>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <h4 class="text-md font-medium text-gray-700">Search Success Rate</h4>
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ round(($total_book_searches - $book_no_result_searches) / $total_book_searches * 100) }}% success</span>
                            </div>
                            <div class="chart-container" style="height: 250px;">
                                <canvas id="failedSearchChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Segmentation Tab -->
        <div class="tab-pane hidden" id="user-segmentation">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- User Stats -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">User Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Total Users</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $user_count }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Active Users</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $active_user_count }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">New This Month</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $registration_users->last()->total }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Avg. Activity</p>
                            <p class="text-2xl font-semibold text-gray-800">3.2/day</p>
                        </div>
                    </div>
                </div>

                <!-- Top Borrowers -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Top Borrowers</h3>
                        <a href="{{ route('admin.borrow') }}" class="text-sm text-blue-600 hover:text-blue-800">View all</a>
                    </div>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="topBorrowersChart"></canvas>
                    </div>
                </div>

                <!-- User Activity Over Time -->
                <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">User Activity Over Time</h3>
                        <div class="flex gap-2">
                            <button class="text-xs px-3 py-1 bg-blue-50 text-blue-600 rounded-full">Daily</button>
                            <button class="text-xs px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Weekly</button>
                            <button class="text-xs px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Monthly</button>
                        </div>
                    </div>
                    <div class="chart-container" style="height: 350px;">
                        <canvas id="userActivityPatternsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Book Performance Tab -->
        <div class="tab-pane hidden" id="book-performance">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Borrowed Books -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Top Borrowed Books</h3>
                        <a href="{{ route('admin.borrow') }}" class="text-sm text-blue-600 hover:text-blue-800">View all</a>
                    </div>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="borrowedBooksChart"></canvas>
                    </div>
                </div>

                <!-- Borrowing Trends -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Borrowing Trends</h3>
                        <div class="text-sm text-gray-500">Last 12 months</div>
                    </div>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="borrowingTrendsChart"></canvas>
                    </div>
                </div>

                <!-- Most Commented Books -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Most Commented Books</h3>
                        <a href="{{ route('book.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View all</a>
                    </div>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="mostCommentedBooksChart"></canvas>
                    </div>
                </div>

                <!-- Book Categories Distribution -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Book Categories</h3>
                        <div class="text-sm text-gray-500">By popularity</div>
                    </div>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="bookCategoriesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Forum Analytics Tab -->
        <div class="tab-pane hidden" id="forum-analytics">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Forum Stats -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Forum Statistics</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Total Forums</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $forum_count }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Total Threads</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $thread_count }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Total Comments</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $comment_count }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Active Discussions</p>
                            <p class="text-2xl font-semibold text-gray-800">24</p>
                        </div>
                    </div>
                </div>

                <!-- Total Threads in Forum -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Threads by Forum</h3>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View all</a>
                    </div>
                    <div class="chart-container" style="height: 300px;">
                        <canvas id="TotalThreadsChart"></canvas>
                    </div>
                </div>

                <!-- Forum Activity Over Time -->
                <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Forum Activity Trend</h3>
                        <div class="flex gap-2">
                            <button class="text-xs px-3 py-1 bg-blue-50 text-blue-600 rounded-full">Daily</button>
                            <button class="text-xs px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Weekly</button>
                            <button class="text-xs px-3 py-1 bg-gray-100 text-gray-600 rounded-full">Monthly</button>
                        </div>
                    </div>
                    <div class="chart-container" style="height: 350px;">
                        <canvas id="forumActivityTrendChart"></canvas>
                    </div>
                </div>

                <!-- Top Forum Contributors -->
                <div class="bg-white rounded-xl shadow-sm p-6 lg:col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Top Contributors</h3>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-800">View all</a>
                    </div>
                    <div class="chart-container" style="height: 300px;">
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
                // Remove active class from all tabs
                document.querySelectorAll('.tab-button').forEach(t => {
                    t.classList.remove('border-blue-500', 'text-blue-600');
                    t.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                });
                
                // Hide all panes
                document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));
                
                // Add active class to clicked tab
                this.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
                this.classList.add('border-blue-500', 'text-blue-600');
                
                // Show corresponding pane
                const paneId = this.getAttribute('data-tab');
                document.getElementById(paneId).classList.remove('hidden');
            });
        });

        // Chart configuration with modern theme
        const chartTheme = {
            colors: {
                blue: {
                    light: 'rgba(59, 130, 246, 0.7)',
                    dark: 'rgba(59, 130, 246, 1)',
                    bg: 'rgba(59, 130, 246, 0.1)'
                },
                green: {
                    light: 'rgba(16, 185, 129, 0.7)',
                    dark: 'rgba(16, 185, 129, 1)',
                    bg: 'rgba(16, 185, 129, 0.1)'
                },
                orange: {
                    light: 'rgba(249, 115, 22, 0.7)',
                    dark: 'rgba(249, 115, 22, 1)',
                    bg: 'rgba(249, 115, 22, 0.1)'
                },
                purple: {
                    light: 'rgba(139, 92, 246, 0.7)',
                    dark: 'rgba(139, 92, 246, 1)',
                    bg: 'rgba(139, 92, 246, 0.1)'
                },
                pink: {
                    light: 'rgba(236, 72, 153, 0.7)',
                    dark: 'rgba(236, 72, 153, 1)',
                    bg: 'rgba(236, 72, 153, 0.1)'
                }
            },
            grid: {
                display: true,
                color: 'rgba(0, 0, 0, 0.05)',
                drawBorder: false
            },
            tooltip: {
                backgroundColor: '#1F2937',
                titleFont: { size: 14, weight: 'bold' },
                bodyFont: { size: 12 },
                padding: 12,
                cornerRadius: 8,
                displayColors: false
            }
        };

        // Common chart options
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { 
                    display: false,
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: chartTheme.tooltip
            },
            scales: {
                x: {
                    grid: chartTheme.grid
                },
                y: {
                    grid: chartTheme.grid,
                    beginAtZero: true
                }
            },
            elements: {
                bar: {
                    borderRadius: 6,
                    borderSkipped: 'bottom'
                },
                line: {
                    tension: 0.3,
                    fill: false,
                    borderWidth: 2
                }
            }
        };

        // Visitor Activity Chart
        new Chart(document.getElementById('visitorActivityChart'), {
            type: 'bar',
            data: {
                labels: ['Today', 'Last 7 Days', 'Last 30 Days'],
                datasets: [{
                    label: 'Visitors',
                    data: [@json($daily_visits), @json($weekly_visits), @json($monthly_visits)],
                    backgroundColor: [
                        chartTheme.colors.blue.light,
                        chartTheme.colors.green.light,
                        chartTheme.colors.purple.light
                    ],
                    borderColor: [
                        chartTheme.colors.blue.dark,
                        chartTheme.colors.green.dark,
                        chartTheme.colors.purple.dark
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                plugins: { 
                    ...commonOptions.plugins,
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    ...commonOptions.scales,
                    y: {
                        ...commonOptions.scales.y,
                        ticks: {
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Most Borrowed Books Chart
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
                    backgroundColor: chartTheme.colors.blue.light,
                    borderColor: chartTheme.colors.blue.dark,
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                indexAxis: 'y',
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} borrows`;
                            }
                        }
                    }
                }
            }
        });

        // Top Search Terms Chart
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
                    backgroundColor: chartTheme.colors.purple.light,
                    borderColor: chartTheme.colors.purple.dark,
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} searches`;
                            }
                        }
                    }
                }
            }
        });

        // Registration Trend Chart
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
                    backgroundColor: chartTheme.colors.blue.bg,
                    borderColor: chartTheme.colors.blue.dark,
                    borderWidth: 2,
                    pointBackgroundColor: chartTheme.colors.blue.dark,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} new users`;
                            }
                        }
                    }
                }
            }
        });

        // Borrowing Trend Chart
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
                    backgroundColor: chartTheme.colors.green.bg,
                    borderColor: chartTheme.colors.green.dark,
                    borderWidth: 2,
                    pointBackgroundColor: chartTheme.colors.green.dark,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} borrows`;
                            }
                        }
                    }
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
                    backgroundColor: [chartTheme.colors.blue.light, chartTheme.colors.orange.light],
                    borderColor: [chartTheme.colors.blue.dark, chartTheme.colors.orange.dark],
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                const percentage = Math.round((context.raw / totalSearches) * 100);
                                return `${context.label}: ${context.raw} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // Total Threads Chart
        const forum = @json($threads_count_per_forum);
        const forumLabels = forum.map(t => t.forum_title);
        const threadCount = forum.map(t => t.threads_count);

        new Chart(document.getElementById('TotalThreadsChart'), {
            type: 'bar',
            data: {
                labels: forumLabels,
                datasets: [{
                    label: 'Threads',
                    data: threadCount,
                    backgroundColor: chartTheme.colors.purple.light,
                    borderColor: chartTheme.colors.purple.dark,
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                indexAxis: 'y',
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} threads`;
                            }
                        }
                    }
                }
            }
        });

        // Most Commented Books Chart
        const books = @json($most_commented_books);

        function wrapLabel(label, maxLength) {
            const words = label.split(' ');
            let line = '';
            const lines = [];

            words.forEach(word => {
                if ((line + word).length > maxLength) {
                    lines.push(line.trim());
                    line = '';
                }
                line += word + ' ';
            });

            if (line.trim()) lines.push(line.trim());

            return lines;
        }

        if (books.length > 0) {
            const labels = books.map(b => wrapLabel(b.book_title, 20));
            const data = books.map(b => b.all_comments_count);

            new Chart(document.getElementById('mostCommentedBooksChart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Comments',
                        data: data,
                        backgroundColor: chartTheme.colors.green.light,
                        borderColor: chartTheme.colors.green.dark,
                        borderWidth: 1
                    }]
                },
                options: {
                    ...commonOptions,
                    plugins: {
                        ...commonOptions.plugins,
                        tooltip: {
                            ...chartTheme.tooltip,
                            callbacks: {
                                label: function(context) {
                                    return `${context.raw} comments`;
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
        }

        // Top Borrowers Chart
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
                    backgroundColor: chartTheme.colors.orange.light,
                    borderColor: chartTheme.colors.orange.dark,
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} borrows`;
                            }
                        }
                    }
                }
            }
        });

        // User Activity Patterns Chart
        new Chart(document.getElementById('userActivityPatternsChart'), {
            type: 'line',
            data: {
                labels: ['00:00', '04:00', '08:00', '12:00', '16:00', '20:00'],
                datasets: [{
                    label: 'Active Users',
                    data: [10, 20, 150, 200, 180, 120],
                    backgroundColor: chartTheme.colors.blue.bg,
                    borderColor: chartTheme.colors.blue.dark,
                    borderWidth: 2,
                    fill: true,
                    pointBackgroundColor: chartTheme.colors.blue.dark,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} active users`;
                            }
                        }
                    }
                }
            }
        });

        // Book Categories Chart
        new Chart(document.getElementById('bookCategoriesChart'), {
            type: 'doughnut',
            data: {
                labels: ['Fiction', 'Non-Fiction', 'Science', 'History', 'Biography'],
                datasets: [{
                    data: [120, 80, 60, 40, 30],
                    backgroundColor: [
                        chartTheme.colors.blue.light,
                        chartTheme.colors.green.light,
                        chartTheme.colors.orange.light,
                        chartTheme.colors.purple.light,
                        chartTheme.colors.pink.light
                    ],
                    borderColor: [
                        chartTheme.colors.blue.dark,
                        chartTheme.colors.green.dark,
                        chartTheme.colors.orange.dark,
                        chartTheme.colors.purple.dark,
                        chartTheme.colors.pink.dark
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((context.raw / total) * 100);
                                return `${context.label}: ${context.raw} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });

        // Forum Activity Trend Chart
        new Chart(document.getElementById('forumActivityTrendChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'New Threads',
                        data: [12, 19, 15, 20, 18, 22],
                        backgroundColor: chartTheme.colors.blue.bg,
                        borderColor: chartTheme.colors.blue.dark,
                        borderWidth: 2,
                        pointBackgroundColor: chartTheme.colors.blue.dark,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3
                    },
                    {
                        label: 'Comments',
                        data: [45, 60, 55, 80, 75, 90],
                        backgroundColor: chartTheme.colors.green.bg,
                        borderColor: chartTheme.colors.green.dark,
                        borderWidth: 2,
                        pointBackgroundColor: chartTheme.colors.green.dark,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3
                    }
                ]
            },
            options: {
                ...commonOptions,
                plugins: {
                    ...commonOptions.plugins,
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw}`;
                            }
                        }
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
                    backgroundColor: chartTheme.colors.purple.light,
                    borderColor: chartTheme.colors.purple.dark,
                    borderWidth: 1
                }]
            },
            options: {
                ...commonOptions,
                indexAxis: 'y',
                plugins: {
                    ...commonOptions.plugins,
                    tooltip: {
                        ...chartTheme.tooltip,
                        callbacks: {
                            label: function(context) {
                                return `${context.raw} contributions`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush