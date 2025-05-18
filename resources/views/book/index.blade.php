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
        <form action="{{ route('book.filter') }}" method="GET">
            <select name="author">
                <option value="">All Authors</option>
                @foreach($authors as $author)
                    <option value="{{ $author }}" {{ request('author') == $author ? 'selected' : '' }}>{{ $author }}</option>
                @endforeach
            </select>
        
            <select name="genre">
                <option value="">All Genres</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                @endforeach
            </select>
        
            <select name="format">
                <option value="">All Formats</option>
                <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                <option value="audio" {{ request('format') == 'audio' ? 'selected' : '' }}>Audio</option>
            </select>
        
            <select name="status">
                <option value="">All Statuses</option>
                <option value="true" {{ request('status') == 'true' ? 'selected' : '' }}>Available</option>
                <option value="false" {{ request('status') == 'false' ? 'selected' : '' }}>Not Available</option>
            </select>
        
            <button type="submit">Search</button>
        </form>
        <form method="GET" action="{{ route('book.index') }}" class="mb-4">
            <label for="sort">Sort by:</label>
            <select name="sort" id="sort" onchange="this.form.submit()">
                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
            </select>
        </form>
        <p>Showing results 
            @if(request('author')) by author: <strong>{{ request('author') }}</strong> @endif
            @if(request('genre')) in genre: <strong>{{ request('genre') }}</strong> @endif
            @if(request('format')) as format: <strong>{{ request('format') }}</strong> @endif
            @if(request('status')) with status: <strong>{{ request('status') }}</strong> @endif
        </p>
        
                
        <h4>Available Books</h4>
        
        @if ($book->isEmpty())
            <p class="font-semibold mt-4">Sorry, not found.</p>
        @else
            <ul class="book-list list-none {{ $layout == 'layouts.backend' ? 'admin' : '' }}">
                @foreach ($book as $book_item)
                    <li>
                        <x-card href="{{ route('book.show', $book_item->id) }}">
                            <div class="card-list">
                                <img src="{{ asset('image/' . $book_item->image_path) }}" alt="">
                                <h4>{{ $book_item->book_title }}</h4>
                                {{-- Admins & Librarians see Edit/Delete --}}
                                @if($layout == 'layouts.backend')
                                    <div class="card-list" style="width: 100%">
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
        @endif

        {{ $book->links() }}
    </div>
@endsection
