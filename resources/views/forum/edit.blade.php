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
    <h4>Edit Forum</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('forum.update', $forum->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="forum_title">Forum Title</label>
            <input type="text" name="forum_title" id="forum_title" value="{{ old('forum_title', $forum->forum_title) }}" class="form-control" required>
        </div>

        <div class="form-group mt-3">
            <label for="forum_description">Forum Description</label>
            <textarea name="forum_description" id="forum_description" class="form-control">{{ old('forum_description', $forum->forum_description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Forum</button>
        <a href="{{ route('forum.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
