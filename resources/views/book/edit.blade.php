@extends('layouts.backend')

@section('content')
    <h4>Update Book</h4>
    <form method="POST" action="{{ route('book.update',$book->id) }}"  enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="book_title">Book Name</label>
            <input type="text" id="book_title" name="book_title" class="form-control" value="{{ $book->book_title }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="author">Author</label>
            <input type="text" id="author" name="author" class="form-control" value="{{ $book->author }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="book_description">Book Description</label>
            <textarea row="5" id="book_description" name="book_description" class="form-control">{{ $book->book_description }}</textarea>
        </div>
        <div class="form-group mb-3">
            <label for="genre">Genre</label>
            <select name="genre" id="genre" required>
                <optgroup label="Fiction">
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
                  <option value="children" {{ $book->genre == 'children' ? 'selected' : '' }}>Children’s / Middle Grade</option>
                </optgroup>
            
                <optgroup label="Non-Fiction">
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
        <div class="form-group mb-3">
            <label for="format">Format</label>
            <select name="format" id="format" required>
                <option value="pdf" {{ $book->format == 'pdf' ? 'selected' : '' }}>e-Book</option>
                <option value="audio" {{ $book->format == 'audio' ? 'selected' : '' }}>Audiophile</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="book_publication_date">Publication Date</label>
            <input type="date" id="book_publication_date" name="book_publication_date" class="form-control" value="{{ $book->book_publication_date }}" required>
        </div>
        {{-- MEDIA BLOCK --}}
        @if ($book->media_path)
        <div id="mediaPreview">
            @if(Str::endsWith($book->media_path, ['.mp3']))
                <p>Current Audio: <audio controls src="{{ asset('media/' . $book->media_path) }}"></audio></p>
            @else
                <p>Current PDF: <a href="{{ asset('media/' . $book->media_path) }}" target="_blank">View PDF</a></p>
            @endif
            <button type="button" class="btn btn-danger btn-sm" onclick="toggleMediaUpload()">Delete Media</button>
            <input type="hidden" name="delete_media" id="delete_media" value="0">
        </div>
        @endif

        <div class="form-group mb-3" id="mediaUpload" style="{{ $book->media_path ? 'display:none' : '' }}">
            <label for="media_path" class="form-label" id="media_label">Upload PDF or mp3</label>
            <input type="file" name="media_path" id="media_path" class="form-control" accept=".pdf,.mp3,audio/*">
        </div>

        {{-- IMAGE BLOCK --}}
        @if ($book->image_path)
        <div id="imagePreview">
            <p>Current Image:</p>
            <img src="{{ asset('image/' . $book->image_path) }}" alt="Cover Image" width="150">
            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="toggleImageUpload()">Delete Image</button>
            <input type="hidden" name="delete_image" id="delete_image" value="0">
        </div>
        @endif

        <div class="form-group mb-3" id="imageUpload" style="{{ $book->image_path ? 'display:none' : '' }}">
            <label for="image_path" class="form-label">Upload Cover Image</label>
            <input type="file" name="image_path" id="image_path" class="form-control" accept="image/*">
        </div>

        <!-- Repeat for other fields -->
        <button type="submit" class="btn btn-primary" value="Update">Save</button>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif
    </form> 
@endsection
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
    });

    function toggleMediaUpload() {
        document.getElementById('mediaPreview').style.display = 'none';
        document.getElementById('mediaUpload').style.display = 'block';
        document.getElementById('delete_media').value = '1';
    }

    function toggleImageUpload() {
        document.getElementById('imagePreview').style.display = 'none';
        document.getElementById('imageUpload').style.display = 'block';
        document.getElementById('delete_image').value = '1';
    }
</script>