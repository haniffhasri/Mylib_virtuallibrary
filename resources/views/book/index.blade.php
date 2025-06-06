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
        <div class="flex justify-center gap-3 bg-white shadow-xl items-center p-3">
            <form action="{{ route('book.search') }}" method="GET" class="mb-0 w-full h-min">
                <div class="flex">
                    <label for="search-dropdown" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <input type="text" name="q" placeholder="Search books..." value="{{ request('q') }}" id="search-dropdown"
                            class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:focus:border-blue-500" />
                        <button type="submit"
                                class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
            </form>
            <div class="accordion block h-min w-full p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500">
                <div class="accordion-header">
                    <p style="font-size: inherit; font-family: inherit; color: #9ca3af;">Filter</p>
                </div>
                <div class="accordion-content">
                    <form action="{{ route('book.search') }}" method="GET" class="max-w-lg mx-auto space-y-2">
                        <input type="hidden" name="q" value="{{ request('q') }}">
                        <select name="author" class="w-full p-2 border rounded">
                            <option value="">All Authors</option>
                            @foreach($authors as $author)
                                <option value="{{ $author }}" {{ request('author') == $author ? 'selected' : '' }}>{{ $author }}</option>
                            @endforeach
                        </select>
                        <select name="genre" class="w-full p-2 border rounded">
                            <option value="">All Genres</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre }}" {{ request('genre') == $genre ? 'selected' : '' }}>{{ $genre }}</option>
                            @endforeach
                        </select>
                        <select name="format" class="w-full p-2 border rounded">
                            <option value="">Format</option>
                            <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                            <option value="audio" {{ request('format') == 'audio' ? 'selected' : '' }}>Audio</option>
                        </select>
                        <select name="status" class="w-full p-2 border rounded">
                            <option value="">Status</option>
                            <option value="true" {{ request('status') == 'true' ? 'selected' : '' }}>Available</option>
                            <option value="false" {{ request('status') == 'false' ? 'selected' : '' }}>Not Available</option>
                        </select>
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Filter
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <form method="GET" action="{{ route('book.index') }}" class="mb-4 mt-4 flex justify-end">
            <div x-data="{ open: false }" class="relative inline-block text-left">
                <div>
                    <button @click="open = !open"
                        type="button"
                        class="inline-flex w-full justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 border-none shadow-lg ring-1 ring-gray-300 ring-inset hover:bg-gray-50"
                        id="menu-button"
                        aria-expanded="true"
                        aria-haspopup="true">
                        Sort by: {{ ucfirst(request('sort', 'latest')) }}
                        <svg class="-mr-1 size-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <div x-show="open" @click.away="open = false"
                    x-transition
                    class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                    role="menu"
                    aria-orientation="vertical"
                    aria-labelledby="menu-button"
                    tabindex="-1">
                    <div class="py-1" role="none">
                        <a href="{{ route('book.index', ['sort' => 'latest']) }}"
                            class="block px-4 py-2 text-sm {{ request('sort') === 'latest' ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}"
                            role="menuitem">
                            Latest
                        </a>
                        <a href="{{ route('book.index', ['sort' => 'oldest']) }}"
                            class="block px-4 py-2 text-sm {{ request('sort') === 'oldest' ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}"
                            role="menuitem">
                            Oldest
                        </a>
                    </div>
                </div>
            </div>
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
