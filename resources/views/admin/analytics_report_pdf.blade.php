<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Report</title>
</head>
<body>

    <h1>MyLib Analytics Report</h1>
    <p><strong>Generated:</strong> {{ now()->format('Y-m-d H:i') }}</p>

    <h2>User Activity Summary</h2>
    <ul>
        <li>Total Users: {{ $user_count }}</li>
        <li>Active Users: {{ $active_user_count }}</li>
        <li>Daily Visits: {{ $daily_visits }}</li>
        <li>Weekly Visits: {{ $weekly_visits }}</li>
        <li>Monthly Visits: {{ $monthly_visits }}</li>
        <li>Avg User Activity (visits/day): {{ $average_activity }}</li>
    </ul>

    <h2>Registration Trend (Last 12 Months)</h2>
    <table>
        <thead>
            <tr><th>Month</th><th>Registrations</th></tr>
        </thead>
        <tbody>
            @foreach($registration_users as $reg)
                <tr>
                    <td>{{ $reg->month }}</td>
                    <td>{{ $reg->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Borrowing Trends (Last 12 Months)</h2>
    <table>
        <thead>
            <tr><th>Month</th><th>Total Borrows</th></tr>
        </thead>
        <tbody>
            @foreach($borrowing_trends as $trend)
                <tr>
                    <td>{{ $trend->month }}</td>
                    <td>{{ $trend->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Top 5 Most Borrowed Books</h2>
    <table>
        <thead>
            <tr><th>Title</th><th>Total Borrows</th></tr>
        </thead>
        <tbody>
            @foreach($most_borrowed_books as $item)
                <tr>
                    <td>{{ $item->book->title ?? 'N/A' }}</td>
                    <td>{{ $item->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Book Availability</h2>
    <ul>
        <li>Available Books: {{ $available_books }}</li>
        <li>Unavailable Books: {{ $unavailable_books }}</li>
    </ul>

    <h2>Forum & Thread Stats</h2>
    <ul>
        <li>Total Forums: {{ $forum_count }}</li>
        <li>Total Threads: {{ $thread_count }}</li>
        <li>Total Comments on Threads: {{ $comment_count }}</li>
    </ul>

    <h2>Top 10 Most Commented Threads</h2>
    <table>
        <thead>
            <tr><th>Thread Title</th><th>Total Comments</th></tr>
        </thead>
        <tbody>
            @foreach($most_commented_threads as $thread)
                <tr>
                    <td>{{ $thread->thread_title }}</td>
                    <td>{{ $thread->all_comments_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Top 10 Most Commented Books</h2>
    <table>
        <thead>
            <tr><th>Book Title</th><th>Total Comments</th></tr>
        </thead>
        <tbody>
            @foreach($most_commented_books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->all_comments_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Top 5 Borrowers</h2>
    <table>
        <thead>
            <tr><th>User</th><th>Total Borrows</th></tr>
        </thead>
        <tbody>
            @foreach($top_borrowers as $borrower)
                <tr>
                    <td>{{ $borrower->user->name ?? 'Unknown User' }}</td>
                    <td>{{ $borrower->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Book Search Trends</h2>
    <table>
        <thead>
            <tr><th>Search Term</th><th>Searches</th></tr>
        </thead>
        <tbody>
            @foreach($book_search_trends as $search)
                <tr>
                    <td>{{ $search->term }}</td>
                    <td>{{ $search->total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Failed Book Searches</h3>
    <ul>
        <li>Total Book Searches: {{ $search_total }}</li>
        <li>No Result Searches: {{ $book_no_result_searches }}</li>
        <li>Failure Rate: {{ $search_failure_rate }}%</li>
    </ul>
</body>
</html>
