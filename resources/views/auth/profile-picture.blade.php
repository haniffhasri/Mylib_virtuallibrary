@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-800">{{ __('Select Your Profile Picture') }}</h2>
            </div>
            
            <!-- Card Body -->
            <div class="px-6 py-6">
                @if (session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                <form id="profileForm" action="{{ route('profile.picture.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    
                    <!-- File Input -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Profile Picture
                        </label>
                        <div class="mt-1 flex items-center">
                            <input type="file" name="profile_picture" accept="image/*" capture="environment" required
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-md file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-blue-50 file:text-blue-700
                                          hover:file:bg-blue-100">
                        </div>
                    </div>

                    <!-- Hidden Skip Input -->
                    <input type="hidden" name="skip" id="skipInput" value="0">

                    <!-- Buttons -->
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" id="skipButton"
                                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Skip
                        </button>
                        <button type="submit"
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript for Skip button
    document.getElementById('skipButton').addEventListener('click', function() {
        document.getElementById('skipInput').value = '1';
        document.getElementById('profileForm').submit();
    });
</script>
@endsection