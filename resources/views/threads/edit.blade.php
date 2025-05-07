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
    <form method="POST" action="{{ route('forum.threads.update', $thread->id) }}"  enctype="multipart/form-data">
        @csrf
            <div class="mb-3">
                <input type="text" name="thread_title" class="form-control" placeholder="Thread title" value="{{ $thread->thread_title }}" required>
            </div>
            <div class="mb-3">
                <textarea name="thread_body" class="form-control" rows="4" placeholder="What do you want to talk about?" required>{{ $thread->thread_body }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Thread</button>
        </form>
@endsection