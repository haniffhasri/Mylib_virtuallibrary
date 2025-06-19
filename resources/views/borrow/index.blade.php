@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Success Message -->
    @if(session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded relative" role="alert">
            <button type="button" class="absolute top-3 right-3 text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
            <p>{{ session()->get('message') }}</p>
        </div>
    @endif

    <!-- Page Header -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">My Borrowed Books</h2>

    <!-- Books Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($borrow as $borrowed)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <!-- Book Cover -->
            <div class="h-48 overflow-hidden">
                <img src="{{ Storage::disk('s3')->url($borrowed->book->image_path) }}" alt="{{ $borrowed->book->book_title }}" class="w-full h-full object-cover">
            </div>
            
            <!-- Book Details -->
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $borrowed->book->book_title }}</h3>
                
                <!-- Action Button -->
                <img src="{{ Storage::disk('s3')->url($borrowed->book->media_path) }}" target="_blank" 
                   class="block w-full mt-4 px-4 py-2 bg-blue-600 text-white text-center rounded-md hover:bg-blue-700 transition duration-200">
                    {{ $borrowed->book->format === 'audio' ? 'Listen to Audiobook' : 'Read PDF' }}
                </a>

                <!-- View Details Link -->
                <a href="{{ route('book.show', $borrowed->book_id) }}" 
                   class="block w-full mt-2 px-4 py-2 border border-gray-300 text-gray-700 text-center rounded-md hover:bg-gray-50 transition duration-200">
                    View Details
                </a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection