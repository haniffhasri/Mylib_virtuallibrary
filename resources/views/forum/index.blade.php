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
<div class="container mx-auto px-4 py-6 max-w-6xl">
    <!-- Create Forum Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Create New Forum</h3>
        </div>
        @auth
            <form action="{{ route('forum.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="forum_title" class="block text-sm font-medium text-gray-700 mb-1">Forum Name</label>
                    <input type="text" id="forum_title" name="forum_title" placeholder="Forum Name" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="forum_description" class="block text-sm font-medium text-gray-700 mb-1">Forum Description</label>
                    <textarea rows="5" id="forum_description" name="forum_description" placeholder="Describe the forum"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Create Forum
                </button>
                
                @if ($errors->any())
                    <div class="mt-4 space-y-1">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-600">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
            </form>
        @else
            <p class="text-gray-600">
                Please <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Sign in</a> to create a forum.
            </p>
        @endauth
    </div>

    <!-- Forum List Header -->
    <div class="flex items-center justify-between mb-4">
        <h4 class="text-xl font-bold text-gray-800">Forum List</h4>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search Form -->
            <form action="{{ route('forum.search') }}" method="GET" class="flex-1">
                <div class="flex">
                    <label for="search-dropdown" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <input type="text" name="q" placeholder="Search forums..." value="{{ request('q') }}" id="search-dropdown"
                            class="block p-2.5 w-full z-20 text-sm rounded-lg text-gray-900 bg-gray-50 border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:focus:border-blue-500" />
                        <button type="submit"
                                class="absolute top-0 end-0 p-2.5 text-sm rounded-tr-lg rounded-br-lg font-medium h-full text-white bg-blue-700 border focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Search</span>
                        </button>
                    </div>
                </div>
            </form>

            <!-- Time Filter Dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" type="button"
                        class="flex items-center justify-between w-full md:w-auto px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <span>Filter by Time</span>
                    <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                    <form action="{{ route('forum.search') }}" method="GET" class="p-2 space-y-2">
                        <input type="hidden" name="q" value="{{ request('q') }}">
                        <select name="created_at" class="w-full p-2 border rounded">
                            <option value="">Any Time</option>
                            <option value="today" {{ request('created_at') == 'today' ? 'selected' : '' }}>Today</option>
                            <option value="this_week" {{ request('created_at') == 'this_week' ? 'selected' : '' }}>This Week</option>
                            <option value="this_month" {{ request('created_at') == 'this_month' ? 'selected' : '' }}>This Month</option>
                            <option value="this_year" {{ request('created_at') == 'this_year' ? 'selected' : '' }}>This Year</option>
                        </select>
                        <button type="submit" class="w-full px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Apply
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sort Dropdown -->
    <div class="flex justify-end mb-4">
        <div x-data="{ open: false }" class="relative inline-block text-left">
            <div>
                <button @click="open = !open" type="button"
                        class="inline-flex justify-center items-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                        id="sort-menu-button">
                    Sort by: {{ ucfirst(request('sort', 'latest')) }}
                    <svg class="-mr-1 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div x-show="open" @click.away="open = false" x-transition
                 class="absolute right-0 z-10 mt-2 w-40 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <div class="py-1">
                    <a href="{{ route('forum.index', ['sort' => 'latest']) }}"
                       class="block px-4 py-2 text-sm {{ request('sort') === 'latest' ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}">
                        Latest
                    </a>
                    <a href="{{ route('forum.index', ['sort' => 'oldest']) }}"
                       class="block px-4 py-2 text-sm {{ request('sort') === 'oldest' ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}">
                        Oldest
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Forum List -->
    @if ($forum->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600 font-medium">No forums found matching your criteria.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($forum as $forums)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <a href="{{ route('forum.show', $forums->slug) }}" class="block p-6">
                        <h4 class="text-lg font-semibold text-gray-800 hover:text-blue-600">{{ $forums->forum_title }}</h4>
                        @if($forums->forum_description)
                            <p class="mt-2 text-gray-600">{{ Str::limit($forums->forum_description, 150) }}</p>
                        @endif
                        <div class="mt-3 flex items-center text-sm text-gray-500">
                            <span>Created {{ $forums->created_at->diffForHumans() }}</span>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection