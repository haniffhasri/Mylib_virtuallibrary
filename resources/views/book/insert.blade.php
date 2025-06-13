@extends('layouts.backend')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
        <h4 class="text-2xl font-bold mb-6 text-gray-800">Insert New Book</h4>

        <form method="POST" action="{{ route('book.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="book_title" class="block text-sm font-medium text-gray-700 mb-1">Book Name</label>
                <input type="text" id="book_title" name="book_title" value="{{ old('book_title') }}" 
                    class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('book_title') border-red-500 @enderror" required>
                @error('book_title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                <input type="text" id="author" name="author" value="{{ old('author') }}" 
                    class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('author') border-red-500 @enderror" required>
                @error('author')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="flex items-center">
                        <label for="item_id" class="block text-sm font-medium text-gray-700 mb-1">Item ID</label>
                        <x-help-icon-blade>
                            Must be unique
                        </x-help-icon-blade>
                    </div>
                    <input type="text" id="item_id" name="item_id" value="{{ old('item_id') }}" 
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('item_id') border-red-500 @enderror" required>
                    @error('item_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex items-center">
                        <label for="call_number" class="block text-sm font-medium text-gray-700 mb-1">Call Number</label>
                        <x-help-icon-blade>
                            Must be unique
                        </x-help-icon-blade>
                    </div>
                    <input type="text" id="call_number" name="call_number" value="{{ old('call_number') }}" 
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('call_number') border-red-500 @enderror" required>
                    @error('call_number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="flex items-center">
                        <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                        <x-help-icon-blade>
                            Must be unique
                        </x-help-icon-blade>
                    </div>
                    <input type="text" id="isbn" name="isbn" value="{{ old('isbn') }}" 
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('isbn') border-red-500 @enderror" required>
                    @error('isbn')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="book_publication_date" class="block text-sm font-medium text-gray-700 mb-1">Publication Date</label>
                    <input type="date" id="book_publication_date" name="book_publication_date" value="{{ old('book_publication_date') }}" 
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('book_publication_date') border-red-500 @enderror" required>
                    @error('book_publication_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="book_description" class="block text-sm font-medium text-gray-700 mb-1">Book Description</label>
                <textarea rows="5" id="book_description" name="book_description" 
                        class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">{{ old('book_description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                    <select name="genre" id="genre" 
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-white" required>
                        <optgroup label="Fiction">
                            <option value="literary-fiction">Literary Fiction</option>
                            <option value="historical-fiction">Historical Fiction</option>
                            <!-- Other fiction options -->
                        </optgroup>
                        <optgroup label="Non-Fiction">
                            <option value="biography">Biography & Memoir</option>
                            <option value="history">History & Culture</option>
                            <!-- Other non-fiction options -->
                        </optgroup>
                    </select>
                </div>

                <div>
                    <label for="format" class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                    <select name="format" id="format" 
                            class="w-full px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 bg-white" required>
                        <option value="pdf">e-Book</option>
                        <option value="audio">Audiophile</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="media_path" class="block text-sm font-medium text-gray-700 mb-1" id="media_label">Upload PDF or mp3</label>
                <input type="file" name="media_path" id="media_path" 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <div>
                <label for="image_path" class="block text-sm font-medium text-gray-700 mb-1">Upload Cover Image</label>
                <input type="file" name="image_path" id="image_path" accept="image/*" 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
            </div>

            <div class="pt-4">
                <button type="submit" id="submitBtn" 
                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const formatSelect = document.getElementById('format');
        const fileInput = document.getElementById('media_path');
        const mediaLabel = document.getElementById('media_label');

        function updateMediaField() {
            const selectedFormat = formatSelect.value;

            if (selectedFormat === 'pdf') {
                fileInput.accept = '.pdf,application/pdf';
                mediaLabel.innerText = 'Upload PDF';
            } else if (selectedFormat === 'audio') {
                fileInput.accept = '.mp3,audio/*';
                mediaLabel.innerText = 'Upload MP3';
            }

            fileInput.value = ''; // clear previously selected file
        }

        formatSelect.addEventListener('change', updateMediaField);
        updateMediaField(); // initialize on page load

        const submitBtn = document.getElementById('submitBtn');
        submitBtn.addEventListener('click', function (e) {
            const mediaInput = document.getElementById('media_path');
            const form = submitBtn.closest('form');

            if (!mediaInput.value) {
                e.preventDefault();

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You didn't upload a PDF or MP3. This book will be marked as unavailable.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, continue',
                    cancelButtonText: 'No, go back'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        });
    });
</script>
@endsection