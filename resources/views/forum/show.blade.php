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
<div class="container">
    <!-- Forum Info -->
    <div class="mb-4 w-full p-7 flex items-center justify-center flex-col rounded-2xl" style="background-color: #d5d5d5;">
        <h4><b>Welcome to {{ $forum->forum_title }}<b></h4>
        <p class="text-muted" style="margin: 0">{{ $forum->forum_description }}</p>
    </div>

    <!-- Create Thread -->
    <div class="mb-5 accordion block h-min w-full p-2.5 z-20 text-sm text-gray-900 bg-white shadow-xl focus:ring-blue-500 focus:border-blue-500 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500">
        <div class="accordion-header text-black"><strong>Post a New Thread</strong></div>
        <div class="accordion-content">
            @auth
                <form action="{{ route('forum.threads.store', $forum->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="thread_title" class="form-control" placeholder="Thread title" required>
                    </div>
                    <div class="mb-3">
                        <textarea name="thread_body" class="form-control" rows="4" placeholder="What do you want to talk about?" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Post Thread</button>
                </form>
            @else
                <p class="text-sm">Please <a href="{{ route('login') }}">Sign in</a> to create a thread.</p>
            @endauth
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="flex justify-center gap-3 bg-white shadow-xl items-center p-3 mb-6">
        <form action="{{ route('forum.show', $forum->slug) }}" method="GET" class="mb-0 w-full h-min">
            <div class="flex">
                <label for="search-dropdown" class="sr-only">Search</label>
                <div class="relative w-full">
                    <input type="text" name="q" placeholder="Search threads..." value="{{ request('q') }}" id="search-dropdown"
                        class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 border-s-gray-50 border-s-2 border border-gray-300" />
                    <button type="submit"
                            class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 hover:bg-blue-800">
                        <svg class="w-4 h-4" aria-hidden="true" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Date Filter -->
        <div class="accordion block w-full p-2.5 z-20 text-sm text-gray-900 bg-gray-50 border-s-gray-50 border-s-2 border border-gray-300">
            <div class="accordion-header text-gray-400">Select Time</div>
            <div class="accordion-content">
                <form action="{{ route('forum.show', $forum->slug) }}" method="GET" class="space-y-2">
                    <input type="hidden" name="q" value="{{ request('q') }}">
                    <select name="created_at" class="w-full p-2 border rounded">
                        <option value="">Any Time</option>
                        <option value="today" {{ request('created_at') == 'today' ? 'selected' : '' }}>Today</option>
                        <option value="this_week" {{ request('created_at') == 'this_week' ? 'selected' : '' }}>This Week</option>
                        <option value="this_month" {{ request('created_at') == 'this_month' ? 'selected' : '' }}>This Month</option>
                        <option value="this_year" {{ request('created_at') == 'this_year' ? 'selected' : '' }}>This Year</option>
                    </select>
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Filter
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Sort -->
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

    <!-- Threads List -->
    <div class="mt-4">
        <h4>Threads in this forum</h4>
        @forelse($threads as $thread)
            <div class="card mb-3">
                <div class="card-body">
                    <p class="text-sm"><b>
                        <a href="{{ route('threads.show', $thread->id) }}">{{ $thread->thread_title }}</a>
                    </b></p>
                    <p class="text-muted text-sm mb-1">
                        Posted by {{ $thread->user->name }} • {{ $thread->created_at->diffForHumans() }}
                    </p>
                    <p class="text-sm">{{ Str::limit($thread->thread_body, 150) }}</p>
                </div>
            </div>
        @empty
            <p>No Thread yet.</p>
        @endforelse

        <!-- Pagination -->
        <div class="mt-4">
            {{ $threads->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
