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
<div class="min-h-screen bg-gray-100">
    <!-- Profile Header -->
    <div class="bg-white shadow">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative">
                <!-- Cover Photo Placeholder -->
                <div class="h-48 w-full bg-gradient-to-r from-blue-500 to-purple-600 rounded-t-lg"></div>
                
                <!-- Profile Picture and Basic Info -->
                <div class="flex flex-col md:flex-row items-start md:items-end -mt-16 md:-mt-12 px-6 pb-6">
                    <div class="relative">
                        @if ($user->profile_picture === 'default.jpg')
                            <img class="h-32 w-32 rounded-full border-4 border-white bg-white shadow-lg object-cover" src="{{ asset('profile_picture/default.jpg') }}" alt="Default Profile">
                        @else
                            <img class="h-32 w-32 rounded-full border-4 border-white bg-white shadow-lg object-cover" src="{{ Storage::disk('s3')->url($user->profile_picture) }}" alt="{{ Auth::user()->username }}">
                        @endif 
                        <span class="absolute bottom-0 right-0 bg-green-500 rounded-full w-4 h-4 border-2 border-white"></span>
                    </div>
                    
                    <div class="mt-4 md:mt-0 md:ml-6">
                        <div class="flex items-center">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $users->name }}</h1>
                            @if($users->usertype === 'admin')
                                <span class="ml-2 px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Admin</span>
                            @elseif($users->usertype === 'librarian')
                                <span class="ml-2 px-2 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">Librarian</span>
                            @endif
                        </div>
                        <p class="text-gray-600">@<span>{{ $users->username }}</span></p>
                        <p class="mt-2 text-gray-700">{{ $users->bio }}</p>
                        
                        <div class="mt-4 flex flex-wrap gap-3">
                            <a href="{{ route('user.edit', $users->id) }}" 
                               class="flex items-center px-4 py-2 bg-white border border-blue-500 text-blue-500 rounded-full hover:bg-blue-50 transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                                Edit Profile
                            </a>
                            
                            <a href="{{ route('password.request') }}" 
                               class="flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-full hover:bg-gray-50 transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                </svg>
                                Change Password
                            </a>
                            
                            <form action="{{ route('user.deactivate') }}" method="POST" id="deactivateForm">
                                @csrf
                                <button type="submit" 
                                        class="flex items-center px-4 py-2 bg-white border border-red-500 text-red-500 rounded-full hover:bg-red-50 transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Deactivate Account
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Sidebar -->
            <div class="w-full lg:w-1/3">
                <!-- User Details Card -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Details</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="text-gray-900">{{ $users->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Member Since</p>
                            <p class="text-gray-900">{{ $users->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                @if($users->usertype === 'user')
                    <!-- Stats Card -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg text-center font-semibold text-gray-900 mb-4">Reading Stats</h2>
                        <div class="grid">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-blue-600">{{ $borrows->count() }}</p>
                                <p class="text-sm text-gray-500">Books Borrowed</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Content -->
            <div class="w-full lg:w-2/3">
                @if(Auth::user()->usertype === 'user')
                <!-- Wishlist Form -->
                <div class="bg-white rounded-lg shadow mb-6">
                    <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Wish a Book</h3>
                        <x-help-icon-blade>
                            You can wish any book to be added into our database.
                        </x-help-icon-blade>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('wishlist.store') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                                    <input type="text" name="title" required 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                                        <input type="text" name="author" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
                                        <input type="text" name="publisher" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                                    <input type="text" name="isbn" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <textarea name="description" rows="3" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                                              placeholder="Tell us about the book..."></textarea>
                                </div>
                                <div class="flex justify-end">
                                    <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                        Post Wish
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <!-- Borrowed Books Section -->
                @if(!$borrows->isEmpty())
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-900">My Borrowed Books</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($borrows->take(4) as $borrowed)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                                <div class="h-48 overflow-hidden">
                                    <img src="{{ Storage::disk('s3')->url($borrowed->book->image_path) }}" alt="{{ $borrowed->book->book_title }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 flex flex-column items-center pb-3">
                                    <h4 class="font-medium text-2xl text-gray-900">{{ $borrowed->book->book_title }}</h4>
                                    <p class="text-sm text-gray-500 mb-2">Borrowed on {{ $borrowed->created_at->format('M d, Y') }}</p>
                                    <a href="{{ Storage::disk('s3')->url($borrowed->book->media_path) }}" target="_blank" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full hover:bg-blue-200 transition duration-200">
                                        {{ $borrowed->book->format === 'audio' ? 'Listen Now' : 'Read Now' }}
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @if($borrows->count() > 4)
                        <div class="mt-6 text-center">
                            <a href="{{ route('borrow.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                                View All Borrowed Books
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('deactivateForm');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); 

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to deactivate your account?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, deactivate it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); 
            }
        });
    });
</script>
@endsection