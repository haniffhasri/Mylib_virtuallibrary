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
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <div class="profile-show">
                            <p>User Name: {{ $users->name }}</p>
                            <p>Profile Picture: </p><img src="{{ asset('profile_picture/' . $users->profile_picture) }}" alt="Cover Image" width="100" height="100" class="profile-img">
                            <p>Bio: {{ $users->bio }}</p>
                            <p>Email: {{ $users->email }}</p>
                            <p>Created at: {{ $users->created_at }}</p>
                            <a class="btn btn-primary" href="{{ route('user.edit', $users->id) }}">Edit Your Profile</a>
                            @if (Route::has('password.request'))
                                <a class="btn btn-primary" href="{{ route('password.request') }}">
                                    {{ __('Change Your Password') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection