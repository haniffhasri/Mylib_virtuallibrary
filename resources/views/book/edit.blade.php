@extends('layouts.backend')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Update Book</h2>
            <p class="text-gray-600">Edit the book details below</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('book.update',$book->id) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Basic Information</h3>
                
                <!-- Book Title -->
                <div>
                    <label for="book_title" class="block text-sm font-medium text-gray-700 mb-1">Book Title</label>
                    <input type="text" id="book_title" name="book_title" value="{{ $book->book_title }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- Author -->
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                    <input type="text" id="author" name="author" value="{{ $book->author }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>

                <!-- Description -->
                <div>
                    <label for="book_description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea rows="5" id="book_description" name="book_description"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ $book->book_description }}</textarea>
                </div>

                <!-- Genre -->
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                    <select name="genre" id="genre" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <optgroup label="Fiction" class="text-gray-700">
                            <option value="literary-fiction" {{ $book->genre == 'literary-fiction' ? 'selected' : '' }}>Literary Fiction</option>
                            <option value="historical-fiction" {{ $book->genre == 'historical-fiction' ? 'selected' : '' }}>Historical Fiction</option>
                            <option value="contemporary-fiction" {{ $book->genre == 'contemporary-fiction' ? 'selected' : '' }}>Contemporary Fiction</option>
                            <option value="coming-of-age" {{ $book->genre == 'coming-of-age' ? 'selected' : '' }}>Coming-of-Age</option>
                            <option value="mystery" {{ $book->genre == 'mystery' ? 'selected' : '' }}>Mystery</option>
                            <option value="crime-fiction" {{ $book->genre == 'crime-fiction' ? 'selected' : '' }}>Crime Fiction</option>
                            <option value="detective-noir" {{ $book->genre == 'detective-noir' ? 'selected' : '' }}>Detective / Noir</option>
                            <option value="psychological-thriller" {{ $book->genre == 'psychological-thriller' ? 'selected' : '' }}>Psychological Thriller</option>
                            <option value="legal-thriller" {{ $book->genre == 'legal-thriller' ? 'selected' : '' }}>Legal Thriller</option>
                            <option value="spy-espionage" {{ $book->genre == 'spy-espionage' ? 'selected' : '' }}>Spy / Espionage</option>
                            <option value="adventure" {{ $book->genre == 'adventure' ? 'selected' : '' }}>Adventure</option>
                            <option value="survival" {{ $book->genre == 'survival' ? 'selected' : '' }}>Survival</option>
                            <option value="war-fiction" {{ $book->genre == 'war-fiction' ? 'selected' : '' }}>War & Military Fiction</option>
                            <option value="science-fiction" {{ $book->genre == 'science-fiction' ? 'selected' : '' }}>Science Fiction</option>
                            <option value="fantasy" {{ $book->genre == 'fantasy' ? 'selected' : '' }}>Fantasy</option>
                            <option value="dystopian" {{ $book->genre == 'dystopian' ? 'selected' : '' }}>Dystopian</option>
                            <option value="post-apocalyptic" {{ $book->genre == 'post-apocalyptic' ? 'selected' : '' }}>Post-Apocalyptic</option>
                            <option value="alternate-history" {{ $book->genre == 'alternate-history' ? 'selected' : '' }}>Alternate History</option>
                            <option value="paranormal" {{ $book->genre == 'paranormal' ? 'selected' : '' }}>Supernatural / Paranormal</option>
                            <option value="romance" {{ $book->genre == 'romance' ? 'selected' : '' }}>Romance</option>
                            <option value="horror" {{ $book->genre == 'horror' ? 'selected' : '' }}>Horror</option>
                            <option value="drama" {{ $book->genre == 'drama' ? 'selected' : '' }}>Drama / Family Saga</option>
                            <option value="young-adult" {{ $book->genre == 'young-adult' ? 'selected' : '' }}>Young Adult (YA)</option>
                            <option value="children" {{ $book->genre == 'children' ? 'selected' : '' }}>Children's / Middle Grade</option>
                        </optgroup>
                    
                        <optgroup label="Non-Fiction" class="text-gray-700">
                            <option value="biography" {{ $book->genre == 'biography' ? 'selected' : '' }}>Biography & Memoir</option>
                            <option value="history" {{ $book->genre == 'history' ? 'selected' : '' }}>History & Culture</option>
                            <option value="self-help" {{ $book->genre == 'self-help' ? 'selected' : '' }}>Self-Help & Personal Development</option>
                            <option value="business" {{ $book->genre == 'business' ? 'selected' : '' }}>Business & Economics</option>
                            <option value="education" {{ $book->genre == 'education' ? 'selected' : '' }}>Education & Reference</option>
                            <option value="science" {{ $book->genre == 'science' ? 'selected' : '' }}>Science & Technology</option>
                            <option value="lifestyle" {{ $book->genre == 'lifestyle' ? 'selected' : '' }}>Lifestyle</option>
                            <option value="philosophy" {{ $book->genre == 'philosophy' ? 'selected' : '' }}>Philosophy & Psychology</option>
                            <option value="religion" {{ $book->genre == 'religion' ? 'selected' : '' }}>Religion & Spirituality</option>
                            <option value="politics" {{ $book->genre == 'politics' ? 'selected' : '' }}>Politics & Society</option>
                        </optgroup>
                    </select>
                </div>

                <!-- Format -->
                <div>
                    <label for="format" class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                    <select name="format" id="format" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                        <option value="pdf" {{ $book->format == 'pdf' ? 'selected' : '' }}>e-Book</option>
                        <option value="audio" {{ $book->format == 'audio' ? 'selected' : '' }}>Audiobook</option>
                    </select>
                </div>

                <!-- Publication Date -->
                <div>
                    <label for="book_publication_date" class="block text-sm font-medium text-gray-700 mb-1">Publication Date</label>
                    <input type="date" id="book_publication_date" name="book_publication_date" value="{{ $book->book_publication_date }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                </div>
            </div>

            <!-- Media Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Media Files</h3>
                
                <!-- Current Media -->
                @if ($book->media_path)
                <div id="mediaPreview" class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Current Media:</p>
                            @if(Str::endsWith($book->media_path, ['.mp3']))
                                <audio controls src="{{ asset('media/' . $book->media_path) }}" class="w-full"></audio>
                            @else
                                <a href="{{ asset('media/' . $book->media_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800 flex items-center">
                                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    View Current PDF
                                </a>
                            @endif
                        </div>
                        <button type="button" onclick="toggleMediaUpload()" 
                            class="text-sm bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg transition duration-200">
                            Replace Media
                        </button>
                    </div>
                    <input type="hidden" name="delete_media" id="delete_media" value="0">
                </div>
                @endif

                <!-- Media Upload -->
                <div id="mediaUpload" class="{{ $book->media_path ? 'hidden' : '' }} bg-gray-50 p-4 rounded-lg">
                    <label for="media_path" class="block text-sm font-medium text-gray-700 mb-2" id="media_label">
                        Upload {{ $book->format == 'audio' ? 'Audiobook (MP3)' : 'PDF' }}
                    </label>
                    <div class="flex items-center">
                        <input type="file" name="media_path" id="media_path" 
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200"
                            accept="{{ $book->format == 'audio' ? '.mp3,audio/*' : '.pdf,application/pdf' }}">
                    </div>
                </div>
            </div>

            <!-- Cover Image Section -->
            <div class="space-y-4">
                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Cover Image</h3>
                
                <!-- Current Image -->
                @if ($book->image_path)
                <div id="imagePreview" class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-700 mb-2">Current Cover:</p>
                            <img src="{{ asset('image/' . $book->image_path) }}" alt="Cover Image" class="h-40 rounded-lg shadow-sm">
                        </div>
                        <button type="button" onclick="toggleImageUpload()" 
                            class="text-sm bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-lg transition duration-200">
                            Replace Image
                        </button>
                    </div>
                    <input type="hidden" name="delete_image" id="delete_image" value="0">
                </div>
                @endif

                <!-- Image Upload -->
                <div id="imageUpload" class="{{ $book->image_path ? 'hidden' : '' }} bg-gray-50 p-4 rounded-lg">
                    <label for="image_path" class="block text-sm font-medium text-gray-700 mb-2">Upload Cover Image</label>
                    <div class="flex items-center">
                        <input type="file" name="image_path" id="image_path" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200">
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t">
                <a href="{{ route('book.index') }}" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                    Update Book
                </button>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mt-6">
                    <div class="bg-red-50 border-l-4 border-red-500 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection

@section('scripts')
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
                mediaLabel.innerText = 'Upload Audiobook (MP3)';
            }

            fileInput.value = ''; // clear previously selected file
        }

        formatSelect.addEventListener('change', updateMediaField);
        updateMediaField(); // initialize on page load
    });

    function toggleMediaUpload() {
        document.getElementById('mediaPreview').classList.add('hidden');
        document.getElementById('mediaUpload').classList.remove('hidden');
        document.getElementById('delete_media').value = '1';
    }

    function toggleImageUpload() {
        document.getElementById('imagePreview').classList.add('hidden');
        document.getElementById('imageUpload').classList.remove('hidden');
        document.getElementById('delete_image').value = '1';
    }
</script>
@endsection