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

<h4>Forum Engagement</h4>
<ul>
    <li>Forums: {{ $forum_count }}</li>
    <li>Threads: {{ $thread_count }}</li>
    <li>Comments: {{ $comment_count }}</li>
</ul>

<h4>Top Search Terms</h4>
<ol>
    @foreach($top_searches as $term)
        <li>{{ $term->term }} — {{ $term->total }}</li>
    @endforeach
</ol>
