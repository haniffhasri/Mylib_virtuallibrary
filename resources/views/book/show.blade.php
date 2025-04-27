@php
    if (Auth::check()) {
        $usertype = Auth::user()->usertype;
        $layout = ($usertype === 'admin' || $usertype === 'librarian') ? 'layouts.backend' : 'layouts.app';
    } else {
        $layout = 'layouts.app';
    }
@endphp

@extends($layout)

@section('content')
    <div class="book-show">
        <h2>{{ $book->book_title }}</h2>
        
        <img src="{{ asset('image/' . $book->image_path) }}" alt="Cover Image" width="200">

        <p>{{ $book->book_description }}</p>
        <p><strong>Genre:</strong> {{ $book->genre }}</p>
        <p><strong>Written by:</strong> {{ $book->author }}</p>
        <p><strong>Format:</strong> {{ $book->format }}</p>
        <p><strong>Published:</strong> {{ $book->book_publication_date }}</p>

        @if ($book->status)
            <p><strong>Status: </strong>Available</p>
        @else
            <p><strong>Status: </strong>Unavailable</p>
        @endif

        {{-- Check if the book has a media file --}}
        @if ($book->media_path)
            @auth
                @if ($layout == 'layouts.backend')
                    {{-- Admin or Librarian View --}}
                    <p>
                        <a class="btn btn-info" href="{{ asset('media/' . $book->media_path) }}" target="_blank" id="media_label">
                            {{ $book->format === 'audio' ? 'Listen to Audiophile' : 'Read PDF' }}
                        </a>
                        <a class="btn btn-info" href="{{ route('book.edit', $book->id) }}">Update</a>
                        <a class="btn btn-danger" href="{{ route('book.destroy', $book->id) }}">Delete</a>
                    </p>
                @elseif (Auth::user()->usertype === 'user')
                    {{-- Regular User View --}}
                    @if ($borrow->contains('book_id', $book->id))
                        <p>
                            <a class="btn btn-primary" href="{{ asset('media/' . $book->media_path) }}" target="_blank" id="media_label">
                                {{ $book->format === 'audio' ? 'Listen to Audiophile' : 'Read PDF' }}
                            </a>
                        </p>
                    @else
                        <a class="btn btn-primary" href="{{ route('borrow_book', $book->id) }}">Borrow</a>
                    @endif
                @endif
            @else
                {{-- Guests (not logged in) --}}
                <a class="btn btn-primary" href="{{ route('login') }}">Borrow</a>
            @endauth
        @endif
    </div>

    @include('components.comment', ['book' => $book])
@endsection
