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
    <div class="mb-4 py-4">
        <h4>{{ $forum->forum_title }}</h4>
        <h5 style="font-size: 1.2em; margin-bottom: 0;">Description</h5>
        <p class="text-muted">{{ $forum->forum_description }}</p>
    </div>

    <!-- Create Thread -->
    <div class="mb-5">
        <h4>Start a new discussion</h4>

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
            <h5>Please <a href="{{ route('login') }}">Sign in</a> to create a thread.</h5>
        @endauth
    </div>

    <!-- List Threads -->
    <div class="mt-4">
        <h4>Threads in this forum</h4>

        @forelse($forum->threads as $thread)
            <div class="card mb-3">
                <div class="card-body">
                    <p><b>
                        <a href="{{ route('threads.show', $thread->id) }}">{{ $thread->thread_title }}</a>
                    </b></p>
                    <p class="text-muted mb-1">
                        Posted by {{ $thread->user->name }} • {{ $thread->created_at->diffForHumans() }}
                    </p>
                    <p>{{ Str::limit($thread->thread_body, 150) }}</p>
                </div>
            </div>
        @empty
            <p>No threads yet. Be the first to post!</p>
        @endforelse
    </div>
</div>
@endsection