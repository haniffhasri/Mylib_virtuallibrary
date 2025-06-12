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
    <div class="book-show">
        <h4>{{ $book->book_title }}</h4>
        
        <img src="{{ asset('image/' . $book->image_path) }}" alt="Cover Image" width="200">

        @php
            $average = $book->averageRating(); // e.g. 3.7
            $fullStars = floor($average);
            $halfStar = ($average - $fullStars) >= 0.25 && ($average - $fullStars) < 0.75;
            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        @endphp

        <div class="flex items-center space-x-1">
            {{-- Full Stars --}}
            @for ($i = 0; $i < $fullStars; $i++)
                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 22 20">
                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                </svg>
            @endfor

            {{-- Half Star --}}
            @if ($halfStar)
                <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 22 20" fill="currentColor">
                    <defs>
                        <linearGradient id="half">
                            <stop offset="50%" stop-color="currentColor"/>
                            <stop offset="50%" stop-color="#E5E7EB"/> <!-- Tailwind gray-300 -->
                        </linearGradient>
                    </defs>
                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" fill="url(#half)" />
                </svg>
            @endif

            {{-- Empty Stars --}}
            @for ($i = 0; $i < $emptyStars; $i++)
                <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 22 20">
                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                </svg>
            @endfor

            <span class="ml-2 text-sm text-gray-700">
                {{ number_format($average, 1) ?? 'N/A' }} / 5
                ({{ $book->ratings->count() }} ratings)
            </span>
        </div>

        <p>{{ $book->book_description }}</p>
        <p><strong>Genre:</strong> {{ $book->genre }}</p>
        <p><strong>Written by:</strong> {{ $book->author }}</p>
        <p><strong>Format:</strong> {{ $book->format }}</p>
        <p><strong>Published:</strong> {{ $book->book_publication_date }}</p>
        <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
        <p><strong>Item ID:</strong> {{ $book->item_id }}</p>
        <p><strong>Call Number:</strong> {{ $book->call_number }}</p>
        <p><strong>Initial Cataloguer: </strong>{{ $book->initial_cataloguer }}</p>

        @if ($book->status)
            <p><strong>Status: </strong>Available</p>
        @else
            <p><strong>Status: </strong>Unavailable</p>
        @endif
        
        {{-- rate --}}
        @auth
        <div class="flex items-center gap-1" style="margin-top: -3.9rem;">
            <p class="mb-2"><strong>Your Rating:</strong></p>
            <form action="{{ route('book.rate', $book->id) }}" method="POST">
                @csrf
                <div class="flex flex-row-reverse justify-center rating gap-1">
                    @for ($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden peer" required />
                        <label for="star{{ $i }}" class="cursor-pointer text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-500">
                            <svg class="w-6 h-6 transition-colors duration-200" fill="currentColor" viewBox="0 0 22 20">
                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                            </svg>
                        </label>
                    @endfor
                </div>
                <div class="mt-2">
                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Rate</button>
                </div>
            </form>
        </div>
        @endauth

        {{-- Check if the book has a media file --}}
        @if ($book->media_path)
            @auth
                @if ($layout == 'layouts.backend')
                    {{-- Admin or Librarian View --}}
                    <p>
                        <a class="btn btn-info" href="{{ asset('media/' . $book->media_path) }}" target="_blank" id="media_label">
                            {{ $book->format === 'audio' ? 'Listen to Audiophile' : 'Read PDF' }}
                        </a>
                        <a class="btn btn-info" href="{{ route('book.edit', $book->id) }}">Update</a>
                        <a class="btn btn-danger" href="{{ route('book.destroy', $book->id) }}">Delete</a>
                    </p>
                @elseif (Auth::user()->usertype === 'user')
                    {{-- Regular User View --}}
                    @if ($borrowedBookIds->contains($book->id))
                        <p>
                            <a class="btn btn-primary" href="{{ asset('media/' . $book->media_path) }}" target="_blank" id="media_label">
                                {{ $book->format === 'audio' ? 'Listen to Audiophile' : 'Read PDF' }}
                            </a>
                        </p>
                    @else
                        <a class="btn btn-primary" href="{{ route('borrow.book', $book->id) }}">Borrow</a>
                    @endif
                @endif
            @else
                {{-- Guests (not logged in) --}}
                <a class="btn btn-primary" href="{{ route('login') }}">Borrow</a>
            @endauth
        @endif
    </div>

    <x-comment :model="$book" />
@endsection

@push('scripts')
<script>
    document.addEventListener('click', function (e) {
        const editBtn = e.target.closest('.toggle-edit');
        const cancelBtn = e.target.closest('.cancel-edit');
        const replyBtn = e.target.closest('.toggle-reply');
        const cancelReplyBtn = e.target.closest('.cancel-reply');

        if (editBtn) {
            const commentId = editBtn.dataset.commentId;
            const form = document.getElementById('edit-form-' + commentId);
            if (form) {
                form.style.display = (form.style.display === 'none') ? 'block' : 'none';
            }
        }

        if (cancelBtn) {
            const commentId = cancelBtn.dataset.commentId;
            const form = document.getElementById('edit-form-' + commentId);
            if (form) {
                form.style.display = 'none';
            }
        }

        if (replyBtn) {
            const commentId = replyBtn.dataset.commentId;
            const form = document.getElementById('reply-form-' + commentId);
            if (form) {
                form.style.display = (form.style.display === 'none') ? 'block' : 'none';
            }
        }

        if (cancelReplyBtn) {
            const commentId = cancelReplyBtn.dataset.commentId;
            const form = document.getElementById('reply-form-' + commentId);
            if (form) {
                form.style.display = 'none';
            }
        }
    });
</script>
@endpush
