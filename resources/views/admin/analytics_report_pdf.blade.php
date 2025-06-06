<h2>Library Analytics Report</h2>
<p><strong>Generated:</strong> {{ now() }}</p>

<h4>Visitor Activity</h4>
<ul>
    <li>Today: {{ $daily_visits }}</li>
    <li>Last 7 Days: {{ $weekly_visits }}</li>
    <li>Last 30 Days: {{ $monthly_visits }}</li>
</ul>

<h4>Registration Trend (Last 12 Months)</h4>
<ul>
    @foreach($registration_users as $row)
        <li>{{ $row->month }}: {{ $row->total }} registrations</li>
    @endforeach
</ul>

<h4>Top 5 Borrowed Books</h4>
<ol>
    @foreach($most_borrowed_books as $b)
        <li>{{ $b->book->book_title }} — {{ $b->total }} times</li>
    @endforeach
</ol>
<h4>Top Book Search Terms</h4>
<ol>
    @foreach($top_searches as $term)
        <li>{{ $term->term }} — {{ $term->total }}</li>
    @endforeach
</ol>

<h4>Most Commented Threads</h4>
<ol>
    @foreach($most_commented_threads as $thread)
        <li>{{ $thread->title }} — {{ $thread->comments_count }} comments</li>
    @endforeach
</ol>

{{-- <h4>Most Commented Books</h4>
<ol>
    @foreach($most_commented_books as $book)
        <li>{{ $book->book_title }} — {{ $book->comments_count }} comments</li>
    @endforeach
</ol> --}}

{{-- <h4>Top Borrowers</h4>
    <ol>
        @foreach($top_borrowers as $user)
            <li>{{ $user->user->name ?? 'N/A' }} — {{ $user->total }} borrows</li>
        @endforeach
    </ol> --}}

{{-- <h4>Search Performance</h4>
<ul>
    <li>Total Book Searches: {{ $search_total }}</li>
    <li>Failed Searches (No Results): {{ $search_failures }}</li>
    <li>Failure Rate: {{ $search_failure_rate }}%</li>
</ul> --}}