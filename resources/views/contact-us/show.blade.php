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
        <div class="mb-3">
            <h4 class="h3 d-inline align-middle">Contact Us</h4>
            @if (!Auth::check())
            @elseif (Auth::user()->usertype === 'admin')
                <x-help-icon-blade>
                    Page to modify our contact information
                </x-help-icon-blade>
            @else
            @endif
        </div>
        <div class="bg-blue-50 rounded-lg shadow-sm p-6 mb-8">
        <div class="space-y-3">
            <p class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                    {{ $contact->email }}
                </a>
            </p>
            <p class="flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <a href="tel:{{ $contact->contact }}" class="text-blue-600 hover:text-blue-800 hover:underline">
                    {{ $contact->contact }}
                </a>
            </p>
        </div>
    </div>
        @auth
            @if(Auth::user()->usertype === 'admin') 
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center gap-2 mb-6">
                        <h4 class="h3 d-inline align-middle">Update Contact Information</h4>
                    </div> 
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <form class="space-y-4" method="POST" action="{{ route('contact-us.update', ['id' => 1]) }}"  enctype="multipart/form-data">
                                @csrf
                                <div class="mb-5">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('email') border-red-500 @enderror" value="{{ $contact->email }}" required>
                                </div>
                                <div class="mb-5">
                                    <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                                    <input type="text" id="contact" name="contact" class="form-control" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('contact') border-red-500 @enderror" value="{{ $contact->contact }}" required>
                                </div>
                                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" id="submitBtn">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endauth
    </div>
@endsection