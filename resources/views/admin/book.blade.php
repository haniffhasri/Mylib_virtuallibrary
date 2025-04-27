@extends('layouts.backend')

@section('content')    
<div>
        <h2>Available Books</h2>
        <ul class="book-list">
            @foreach ($book as $book_item)
            <li>
                <x-card href="{{ route('book.show', $book_item->id) }}">
                        <h3>{{ $book_item->book_title }}</h3>
                </x-card>
            </li>
            @endforeach        
        </ul>

        {{ $book->links() }}
    </div>
@endsection