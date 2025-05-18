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
                @if(Auth::user()->usertype === 'user')
                    <div>
                        <h4 class="py-6">Borrowed Books</h4>
                        <ul class="borrowed-book list-none">
                            @foreach($borrows as $borrowed)
                                    <li>
                                        <x-card href="{{ route('book.show', $borrowed->book_id) }}">
                                            <div class="card-list">
                                                <img src="{{ asset('image/' . $borrowed->book->image_path) }}" alt="{{ $borrowed->book->book_title }}">
                                                <p>Book: {{ $borrowed->book->book_title }}</p>
                                                <a class="btn btn-primary" href="{{ asset('media/' . $borrowed->book->media_path) }}" target="_blank" id="media_label">
                                                    {{ $borrowed->book->format === 'audio' ? 'Listen to Audiophile' : 'Read PDF' }}
                                                </a>         
                                            </div>               
                                        </x-card>
                                    </li>
                            @endforeach 
                            <a href="{{ route('borrow.index') }}" class="button center">See more</a>
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection