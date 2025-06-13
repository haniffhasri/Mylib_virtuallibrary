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
         <!-- Books List -->
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Available Books</h2>
        
        @if ($book->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No books found</h3>
                <p class="mt-1 text-gray-500">Try adjusting your search or filter criteria</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($book as $book_item)
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                        <div class="h-48 overflow-hidden">
                            <img src="{{ asset('image/' . $book_item->image_path) }}" alt="{{ $book_item->book_title }}" 
                                class="w-full h-full object-cover">
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2 line-clamp-2">{{ $book_item->book_title }}</h3>
                            
                            <!-- Admin/Librarian Actions -->
                            @if($layout == 'layouts.backend')
                                <div class="flex gap-2 mt-4">
                                    <a href="{{ route('book.edit', $book_item->id) }}" 
                                       class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                        Edit
                                    </a>
                                    <a href="{{ route('book.destroy', $book_item->id) }}" 
                                       class="flex-1 text-center bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                        Delete
                                    </a>
                                </div>
                            @else
                                <!-- User Actions -->
                                @if ($book_item->media_path)
                                    @if ($borrowedBookIds->contains($book_item->id))
                                        <a href="{{ asset('media/' . $book_item->media_path) }}" target="_blank"
                                           class="mt-4 w-full block text-center bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                            {{ $book_item->format === 'audio' ? 'Listen Now' : 'Read PDF' }}
                                        </a>
                                    @else
                                        @auth
                                            <a href="{{ route('borrow.book', $book_item->id) }}"
                                               class="mt-4 w-full block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                                Borrow
                                            </a>
                                        @else
                                            <a href="{{ route('login') }}"
                                               class="mt-4 w-full block text-center bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-lg text-sm font-medium transition duration-200">
                                                Login to Borrow
                                            </a>
                                        @endauth
                                    @endif
                                @else
                                    <p class="mt-2 text-sm text-gray-500 italic">Currently unavailable</p>
                                @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $book->links() }}
    </div>
</div>
@endsection