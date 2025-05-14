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
<form action="{{ route('user.update', $users->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
    
        <div class="form-group mb-3">
            <p>Name: </p>
            <input type="text" name="name" value="{{ $users->name }}">
        </div>
        <div class="form-group mb-3">
            <p>Email: </p>
            <input type="email" name="email" value="{{ $users->email }}">
        </div>
        <div class="form-group mb-3">
            <p>Bio: </p>
            <textarea name="bio" value="{{ $users->bio }}">{{ $users->bio }}</textarea>
        </div>
        <div class="form-group mb-3">
            <p>Profile Picture: </p>
            @if ($users->profile_picture)
                <img src="{{ asset('profiles/' . $users->profile_picture) }}" width="100">
            @endif
        </div>
        <div class="form-group mb-3">
            <input type="file" name="profile_picture">
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
    </form>    
@endsection