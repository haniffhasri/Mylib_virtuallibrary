@extends('layouts.backend')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <h4>Insert New Book</h4>

    <form method="POST" action="{{ route('book.store') }}"  enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="book_title">Book Name</label>
            <input type="text" id="book_title" name="book_title" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="author">Author</label>
            <input type="text" id="author" name="author" class="form-control" required>
        </div>
        <div class="flex gap-2">
            <div class="form-group mb-3 w-full">
                <label for="item_id">Item ID</label>
                <x-help-icon-blade>
                    Must be unique
                </x-help-icon-blade>
                <input type="text" id="item_id" name="item_id" class="form-control" required>
            </div>
            <div class="form-group mb-3 w-full">
                <label for="call_number">Call Number</label>
                <x-help-icon-blade>
                    Must be unique
                </x-help-icon-blade>
                <input type="text" id="call_number" name="call_number" class="form-control" required>
            </div>
        </div>
        <div class="flex gap-2">
            <div class="form-group mb-3 w-full">
                <label for="isbn">ISBN</label>
                <x-help-icon-blade>
                    Must be unique
                </x-help-icon-blade>
                <input type="text" id="isbn" name="isbn" class="form-control" required>
            </div>
            <div class="form-group mb-3 w-full">
                <label for="book_publication_date">Publication Date</label>
                <input type="date" id="book_publication_date" name="book_publication_date" class="form-control" required>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="book_description">Book Description</label>
            <textarea row="5" id="book_description" name="book_description" class="form-control"></textarea>
        </div>
        <div class="flex gap-2">
            <div class="form-group mb-3 w-full">
                <label for="genre">Genre</label>
                <select name="genre" id="genre" class="inline-flex justify-center w-full gap-x-1.5 rounded-md bg-white px-2 py-1 text-gray-900 border-none shadow-lg ring-1 ring-gray-300 ring-inset hover:bg-gray-50" required>
                    <optgroup label="Fiction">
                    <option value="literary-fiction">Literary Fiction</option>
                    <option value="historical-fiction">Historical Fiction</option>
                    <option value="contemporary-fiction">Contemporary Fiction</option>
                    <option value="coming-of-age">Coming-of-Age</option>
                    <option value="mystery">Mystery</option>
                    <option value="crime-fiction">Crime Fiction</option>
                    <option value="detective-noir">Detective / Noir</option>
                    <option value="psychological-thriller">Psychological Thriller</option>
                    <option value="legal-thriller">Legal Thriller</option>
                    <option value="spy-espionage">Spy / Espionage</option>
                    <option value="adventure">Adventure</option>
                    <option value="survival">Survival</option>
                    <option value="war-fiction">War & Military Fiction</option>
                    <option value="science-fiction">Science Fiction</option>
                    <option value="fantasy">Fantasy</option>
                    <option value="dystopian">Dystopian</option>
                    <option value="post-apocalyptic">Post-Apocalyptic</option>
                    <option value="alternate-history">Alternate History</option>
                    <option value="paranormal">Supernatural / Paranormal</option>
                    <option value="romance">Romance</option>
                    <option value="horror">Horror</option>
                    <option value="drama">Drama / Family Saga</option>
                    <option value="young-adult">Young Adult (YA)</option>
                    <option value="children">Children’s / Middle Grade</option>
                    </optgroup>
                
                    <optgroup label="Non-Fiction">
                    <option value="biography">Biography & Memoir</option>
                    <option value="history">History & Culture</option>
                    <option value="self-help">Self-Help & Personal Development</option>
                    <option value="business">Business & Economics</option>
                    <option value="education">Education & Reference</option>
                    <option value="science">Science & Technology</option>
                    <option value="lifestyle">Lifestyle</option>
                    <option value="philosophy">Philosophy & Psychology</option>
                    <option value="religion">Religion & Spirituality</option>
                    <option value="politics">Politics & Society</option>
                    </optgroup>
                </select>
            </div>
            <div class="form-group mb-3 w-full">
                <label for="format">Format</label>
                <select name="format" id="format" class="inline-flex justify-center w-full gap-x-1.5 rounded-md bg-white px-2 py-1 text-gray-900 border-none shadow-lg ring-1 ring-gray-300 ring-inset hover:bg-gray-50" required>
                    <option value="pdf">e-Book</option>
                    <option value="audio">Audiophile</option>
                </select>
            </div>
        </div>
        <div class="form-group mb-3">
            <label for="media_path" class="form-label" id="media_label">Upload PDF or mp3</label>
            <input type="file" name="media_path" id="media_path" class="form-control" accept=".pdf,.mp3,audio/*">
        </div>

        <div class="form-group mb-3">
            <label for="image_path" class="form-label">Upload Cover Image</label>
            <input type="file" name="image_path" id="image_path" class="form-control" accept="image/*">
        </div>
        <!-- Repeat for other fields -->
        <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>

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
        const form = document.querySelector('form'); // Make sure this targets your form

        submitBtn.addEventListener('click', function () {
            const mediaInput = document.getElementById('media_path');

            if (!mediaInput.value) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You didn’t upload a PDF or MP3. This book will be marked as unavailable.',
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
            } else {
                form.submit();
            }
        });
    });
</script>
@endsection