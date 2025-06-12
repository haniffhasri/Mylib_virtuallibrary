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
                <!-- Create Wishlist -->
                    <div class="mb-5 accordion block h-min w-full p-2.5 z-20 text-sm text-gray-900 bg-white shadow-xl focus:ring-blue-500 focus:border-blue-500 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500">
                        <div class="accordion-header text-black">
                            <strong>Wish a book</strong>
                            <x-help-icon-blade>
                                You can wish any book to be added into our database.
                            </x-help-icon-blade>
                        </div>
                        <div class="accordion-content">
                            <form action="{{ route('wishlist.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="text-black">Title: <span style="color: red">*</span></label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="text-black">Author:</label>
                                    <input type="text" name="author" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="text-black">Publisher:</label>
                                    <input type="text" name="publisher" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="text-black">ISBN:</label>
                                    <input type="text" name="isbn" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="text-black">Description:</label>
                                    <textarea name="description" class="form-control" rows="4" placeholder="What is the description?"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Post Wish List</button>
                            </form>
                        </div>
                    </div>
                    <div>
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
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection