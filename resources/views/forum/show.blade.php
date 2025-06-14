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
    <!-- Forum Header -->
    <div class="bg-gray-100 rounded-xl p-8 mb-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome to {{ $forum->forum_title }}</h1>
        @if($forum->forum_description)
            <p class="text-gray-600">{{ $forum->forum_description }}</p>
        @endif
    </div>

    <!-- Create Thread Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6" id="create-thread">
        <div class="border-b border-gray-200 px-6 py-4 bg-gray-50">
            <h3 class="text-lg font-medium text-gray-900">Post a New Thread</h3>
        </div>
        <div class="p-6">
            @auth
                <form action="{{ route('forum.threads.store', $forum->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <input type="text" name="thread_title" placeholder="Thread title" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <textarea name="thread_body" rows="4" placeholder="What do you want to talk about?" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Post Thread
                    </button>
                </form>
            @else
                <p class="text-gray-600">
                    Please <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Sign in</a> to create a thread.
                </p>
            @endauth
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search Form -->
            <form action="{{ route('forum.show', $forum->slug) }}" method="GET" class="flex-1">
                <div class="flex">
                    <label for="search-dropdown" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <input type="text" name="q" placeholder="Search threads..." value="{{ request('q') }}" id="search-dropdown"
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
                    <form action="{{ route('forum.show', $forum->slug) }}" method="GET" class="p-2 space-y-2">
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
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Threads in this forum</h3>
        <form method="GET" action="{{ route('forum.show', $forum->slug) }}" class="mb-4 mt-4 flex justify-end">
        <input type="hidden" name="q" value="{{ request('q') }}">
        <input type="hidden" name="created_at" value="{{ request('created_at') }}">
        <div x-data="{ open: false }" class="relative inline-block text-left">
            <button @click="open = !open"
                type="button"
                class="inline-flex justify-center gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-lg ring-1 ring-gray-300 hover:bg-gray-50"
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

            <div x-show="open" @click.away="open = false"
                x-transition
                class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black/5">
                <div class="py-1">
                    <button type="submit" name="sort" value="latest" style="font-weight: inherit;"
                        class="block w-full text-left px-4 py-2 text-sm border-none bg-white {{ request('sort') === 'latest' ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}">
                        Latest
                    </button>
                    <button type="submit" name="sort" value="oldest" style="font-weight: inherit;"
                        class="block w-full text-left px-4 py-2 text-sm border-none bg-white {{ request('sort') === 'oldest' ? 'bg-gray-100 text-gray-900' : 'text-gray-700' }}">
                        Oldest
                    </button>
                </div>
            </div>
        </div>
    </form>
    </div>

    <!-- Admin Controls -->
    @auth
        @if(Auth::id() === $forum->user_id || Auth::user()->usertype === 'admin')
            <div class="flex gap-2 mb-6">
                <a href="{{ route('forum.edit', $forum->id) }}" 
                   class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                    Edit Forum
                </a>
                <form action="{{ route('forum.destroy', $forum->id) }}" method="POST" class="show-confirm">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Delete Forum
                    </button>
                </form>
            </div>
        @endif
    @endauth

    <!-- Threads List -->
    @forelse($threads as $thread)
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-4 hover:shadow-lg transition-shadow duration-200">
            <a href="{{ route('threads.show', $thread->id) }}" class="block p-6">
                <h3 class="text-lg font-semibold text-gray-800 hover:text-blue-600 mb-1">{{ $thread->thread_title }}</h3>
                <p class="text-gray-600 text-sm mb-3">
                    Posted by <span class="font-medium">{{ $thread->user->name }}</span> • {{ $thread->created_at->diffForHumans() }}
                </p>
                @if($thread->thread_body)
                    <p class="text-gray-700">{{ Str::limit($thread->thread_body, 150) }}</p>
                @endif
            </a>
        </div>
    @empty
        <div class="bg-white rounded-lg shadow-md p-6 text-center">
            <p class="text-gray-600">No threads found in this forum yet.</p>
            @auth
                <p class="mt-2">Be the first to <a href="#create-thread" class="text-blue-600 hover:text-blue-800">start a discussion</a>!</p>
            @endauth
        </div>
    @endforelse

    <!-- Pagination -->
    <div class="mt-6">
        {{ $threads->appends(request()->query())->links() }}
    </div>
</div>
@endsection