@extends('layouts.backend')

@section('content')    
<div>
        <h4>Available Books</h4>
        <ul class="book-list">
            @foreach ($book as $book_item)
            <li>
                <x-card href="{{ route('book.show', $book_item->id) }}">
                        <h4>{{ $book_item->book_title }}</h4>
                </x-card>
            </li>
            @endforeach        
        </ul>

        {{ $book->links() }}
    </div>
@endsection