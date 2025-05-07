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

    <!-- Thread Header -->
    <div class="mb-4 p-4 bg-light rounded shadow-sm">
        <h2>{{ $thread->thread_title }}</h2>
        <p class="text-muted">
            Posted by {{ $thread->user->name }} • {{ $thread->created_at->diffForHumans() }}
        </p>
        <p>{{ $thread->thread_body }}</p>

        @auth
            @if(auth()->id() === $thread->user_id)
                <div class="mt-2">
                    <a href="{{ route('forum.threads.edit', $thread->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ route('forum.threads.delete', $thread->id) }}" class="btn btn-sm btn-danger">Delete</a>
                </div>
            @endif
        @endauth
    </div>

    <!-- Comments Section -->
    <div class="mt-5">
        <h4>Discussion</h4>
        <x-comment :model="$thread" />
    </div>

</div>

@endsection