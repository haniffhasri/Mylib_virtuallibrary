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
    <form method="POST" action="{{ route('forum.store') }}"  enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="forum_title">Forum Name</label>
            <input type="text" id="forum_title" name="forum_title" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="forum_description">Forum Description</label>
            <textarea row="5" id="forum_description" name="forum_description" class="form-control"></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif
    </form>
@endsection