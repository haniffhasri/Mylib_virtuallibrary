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
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Book Header Section -->
    <div class="flex flex-col md:flex-row gap-8 mb-8">
        <!-- Book Cover -->
        <div class="w-full md:w-1/3">
            <img src="{{ Storage::disk('s3')->url($book->image_path) }}" alt="book cover" class="w-full rounded-lg shadow-md">
        </div>
        
        <!-- Book Details -->
        <div class="w-full md:w-2/3">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $book->book_title }}</h1>
            
            <!-- Rating Section -->
            <div class="flex items-center mb-4">
                @php
                    $average = $book->averageRating();
                    $fullStars = floor($average);
                    $halfStar = ($average - $fullStars) >= 0.25 && ($average - $fullStars) < 0.75;
                    $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                @endphp

                <div class="flex items-center mr-2">
                    @for ($i = 0; $i < $fullStars; $i++)
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                        </svg>
                    @endfor

                    @if ($halfStar)
                        <svg class="w-6 h-6 text-yellow-400" viewBox="0 0 22 20" fill="currentColor">
                            <defs>
                                <linearGradient id="half">
                                    <stop offset="50%" stop-color="currentColor"/>
                                    <stop offset="50%" stop-color="#E5E7EB"/>
                                </linearGradient>
                            </defs>
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" fill="url(#half)" />
                        </svg>
                    @endif

                    @for ($i = 0; $i < $emptyStars; $i++)
                        <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 22 20">
                            <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                        </svg>
                    @endfor
                </div>
                
                <span class="text-gray-700">
                    {{ number_format($average, 1) ?? 'N/A' }} ({{ $book->ratings->count() }} ratings)
                </span>
            </div>

            <!-- Book Description -->
            <p class="text-gray-700 mb-6">{{ $book->book_description }}</p>

            <!-- Metadata Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-sm text-gray-500">Genre</p>
                    <p class="text-gray-800">{{ $book->genre }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Author</p>
                    <p class="text-gray-800">{{ $book->author }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Format</p>
                    <p class="text-gray-800">{{ $book->format }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Published</p>
                    <p class="text-gray-800">{{ $book->book_publication_date }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">ISBN</p>
                    <p class="text-gray-800">{{ $book->isbn }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Item ID</p>
                    <p class="text-gray-800">{{ $book->item_id }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Call Number</p>
                    <p class="text-gray-800">{{ $book->call_number }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Cataloguer</p>
                    <p class="text-gray-800">{{ $book->initial_cataloguer }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="text-gray-800 font-medium {{ $book->status ? 'text-green-600' : 'text-red-600' }}">
                        {{ $book->status ? 'Available' : 'Unavailable' }}
                    </p>
                </div>
            </div>

            <!-- Rating Form -->
            @auth
            <div class="mb-6">
                <p class="text-sm font-medium text-gray-700 mb-2">Your Rating:</p>
                <form action="{{ route('book.rate', $book->id) }}" method="POST">
                    @csrf
                    <div class="flex flex-row-reverse justify-end items-center gap-1">
                        @for ($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer" required />
                            <label for="star{{ $i }}" class="cursor-pointer text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-500">
                                <svg class="w-8 h-8 transition-colors duration-200" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                            </label>
                        @endfor
                    </div>
                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        Submit Rating
                    </button>
                </form>
            </div>
            @endauth

            <!-- Action Buttons -->
            @if ($book->media_path)
                @auth
                    @if ($layout == 'layouts.backend')
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ Storage::disk('s3')->url($book->media_path) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                                {{ $book->format === 'audio' ? 'Listen to Audiobook' : 'Read PDF' }}
                            </a>
                            <a href="{{ route('book.edit', $book->id) }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200">
                                Edit Book
                            </a>
                            <a href="{{ route('book.destroy', $book->id) }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition duration-200">
                                Delete Book
                            </a>
                        </div>
                    @elseif (Auth::user()->usertype === 'user')
                        @if ($borrowedBookIds->contains($book->id))
                            <a href="{{ Storage::disk('s3')->url($book->media_path) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                                {{ $book->format === 'audio' ? 'Listen to Audiobook' : 'Read PDF' }}
                            </a>
                        @else
                            <a href="{{ route('borrow.book', $book->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                                Borrow This Book
                            </a>
                        @endif
                    @endif
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        Login to Borrow
                    </a>
                @endauth
            @endif
        </div>
    </div>

    <!-- Comments Section -->
    <div class="mt-8">
        <x-comment :model="$book" />
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle Update Form
        document.querySelectorAll('.toggle-edit').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const commentId = this.dataset.commentId;
                const form = document.getElementById(`edit-form-${commentId}`);
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });
        });

        // Cancel Update
        document.querySelectorAll('.cancel-edit').forEach(button => {
            button.addEventListener('click', function () {
                const commentId = this.dataset.commentId;
                const form = document.getElementById(`edit-form-${commentId}`);
                form.style.display = 'none';
            });
        });

        // Toggle Reply Form
        document.querySelectorAll('.toggle-reply').forEach(button => {
            button.addEventListener('click', function () {
                const commentId = this.dataset.commentId;
                const username = this.dataset.username;
                const form = document.getElementById(`reply-form-${commentId}`);
                const textarea = form.querySelector('textarea');

                // Show the form
                const isHidden = form.style.display === 'none';
                form.style.display = isHidden ? 'block' : 'none';

                if (isHidden && textarea.value.trim() === '') {
                    textarea.value = `${username} `;
                    textarea.focus();
                    textarea.setSelectionRange(textarea.value.length, textarea.value.length);
                }
            });
        });

        // Cancel Reply
        document.querySelectorAll('.cancel-reply').forEach(button => {
            button.addEventListener('click', function () {
                const commentId = this.dataset.commentId;
                const form = document.getElementById(`reply-form-${commentId}`);
                form.style.display = 'none';
            });
        });
    });
</script>
@endpush
@endsection