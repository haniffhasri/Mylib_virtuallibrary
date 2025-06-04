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
                    <div class="card-header bg-dark-blue-premium text-white">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <div class="profile-show">
                            <p class=" text-gray-500 pb-3">@<span>{{ $users->username }}</span></p>
                            <p>Name: {{ $users->name }}</p>
                            <img src="{{ asset('profile_picture/' . $users->profile_picture) }}" alt="Cover Image" width="100" height="100" class="profile-img">
                            <p>Bio: {{ $users->bio }}</p>
                            <p class=" mb-5">Email: {{ $users->email }}</p>
                            <a class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" href="{{ route('user.edit', $users->id) }}">Edit Your Profile</a>
                            @if (Route::has('password.request'))
                                <a class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded" href="{{ route('password.request') }}">
                                    {{ __('Change Your Password') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @if(Auth::user()->usertype === 'user')
                    @if($borrows->isEmpty())
                    @else
                        <div>
                            <h4 class="py-6">My Borrowed Books</h4>
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
                @endif
            </div>
        </div>
    </div>
@endsection