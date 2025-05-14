<style>
    @tailwind utilities;
</style>
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
    <div class="book-container-list">
        <form action="{{ route('book.search') }}" method="GET">
            <input type="text" name="q" placeholder="Search books..." value="{{ request('q') }}">
            <button type="submit">Search</button>
        </form>
                
        <h2>Available Books</h2>
        
        <ul class="book-list {{ $layout == 'layouts.backend' ? 'admin' : '' }}">
            @foreach ($book as $book_item)
                <li>
                    <x-card href="{{ route('book.show', $book_item->id) }}">
                        <div class="card-list">
                            <h3>{{ $book_item->book_title }}</h3>

                            {{-- Admins & Librarians see Edit/Delete --}}
                            @if($layout == 'layouts.backend')
                                <div>
                                    <a class="btn btn-danger" href="{{ route('book.destroy', $book_item->id) }}">Delete</a>
                                    <a class="btn btn-info" href="{{ route('book.edit', $book_item->id) }}">Update</a>
                                </div>

                            {{-- Normal users (or guests) --}}
                            @else
                                @if ($book_item->media_path)
                                    @if ($borrowedBookIds->contains($book_item->id))
                                        <a class="btn btn-primary" href="{{ asset('media/' . $book_item->media_path) }}" target="_blank" id="media_label">
                                            {{ $book_item->format === 'audio' ? 'Listen to Audiophile' : 'Read PDF' }}
                                        </a>
                                    @else
                                        @auth
                                            <a class="btn btn-primary" href="{{ route('borrow.book', $book_item->id) }}">Borrow</a>
                                        @else
                                            <a class="btn btn-primary" href="{{ route('login') }}">Borrow</a>
                                        @endauth
                                    @endif
                                @else
                                    <p>This book is unavailable.</p>
                                @endif
                            @endif
                        </div>
                    </x-card>
                </li>
            @endforeach
        </ul>

        {{ $book->links() }}
    </div>
@endsection
