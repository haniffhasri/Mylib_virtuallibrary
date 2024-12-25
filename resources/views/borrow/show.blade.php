<x-admin_page>
    <table class="borrow-table">
        <tr>
            <th>Borrow id</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Book Title</th>
            <th>Due</th>
        </tr>

        @foreach ($borrow as $borrow)
            <tr>
                <td>{{ $borrow->id }}</td>
                <td>{{ $borrow->user->name }}</td>
                <td>{{ $borrow->user->email }}</td>
                <td>{{ $borrow->book->book_title }}</td>
                <td>{{ $borrow->due_date }}</td>
            </tr>
        @endforeach
    </table>
</x-admin_page>