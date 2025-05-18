@extends('layouts.app')

@section('content')    
    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">X</button>
            {{ session()->get('message') }}
        </div>
    @endif
    
    <h4>Borrowed Books</h4>
    <ul class="borrowed-book list-none">
        @foreach($borrow as $borrowed)
                <li>
                    <x-card href="{{ route('book.show', $borrowed->book_id) }}">
                        <div class="card-list">
                            <img src="{{ asset('image/' . $borrowed->book->image_path) }}" alt="{{ $borrowed->book->book_title }}">
                            <p>Book: {{ $borrowed->book->book_title }}</p>
                            <a class="btn btn-primary" href="{{ asset('media/' . $borrowed->book->media_path) }}" target="_blank" id="media_label">
                                {{ $borrowed->book->format === 'audio' ? 'Listen to Audiophile' : 'Read PDF' }}
                            </a>         
                        </div>               
                    </x-card>
                </li>
        @endforeach 
            </ul>
@endsection