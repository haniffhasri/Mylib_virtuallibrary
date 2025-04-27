@extends('layouts.backend')

@section('content')
    <table class="borrow-table">
        <tr>
            <th>Borrow id</th>
            <th>User Name</th>
            <th>Email</th>
            <th>Book Title</th>
            <th>Due</th>
            <th>Drop</th>
        </tr>

        @foreach ($borrow as $borrow)
            <tr>
                <td>{{ $borrow->id }}</td>
                <td>{{ $borrow->user->name }}</td>
                <td>{{ $borrow->user->email }}</td>
                <td>{{ $borrow->book->book_title }}</td>
                <td>{{ $borrow->due_date }}</td>
                <td>
                    <form action="{{ route('borrow.delete', $borrow->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form></td>
            </tr>
        @endforeach
    </table>
@endsection