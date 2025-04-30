@extends('layouts.backend')

@section('content')
    <table class="borrow-table">
        <tr>
            {{-- <th>Borrow id</th> --}}
            <th>User Name</th>
            <th>Email</th>
            <th>Book Title</th>
            <th>Due</th>
            <th>Drop</th>
        </tr>

        @foreach ($borrow as $borrows)
            <tr>
                {{-- <td>{{ $borrows->id }}</td> --}}
                <td>{{ $borrows->user->name }}</td>
                <td>{{ $borrows->user->email }}</td>
                <td>{{ $borrows->book->book_title }}</td>
                <td>{{ $borrows->due_date }}</td>
                <td>
                    <form action="{{ route('borrow.delete', $borrows->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form></td>
            </tr>
        @endforeach
    </table>
@endsection