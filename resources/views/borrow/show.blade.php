<x-user_page>
    <div>
        <h2>{{ $book->book_title }}</h2>
        <img src="{{ asset('pdfs/' . $book->image_path) }}" alt="Cover Image" width="200">
        <p>{{ $book->book_description }}</p>
        <p><strong>Genre:</strong> {{ $book->genre }}</p>
        <p><strong>Written by:</strong> {{ $book->author }}</p>
        <p><strong>Format:</strong> {{ $book->format }}</p>
        <p><strong>Published:</strong> {{ $book->book_publication_date }}</p>
        @if ($book->status)
            <p><strong>Status: </strong>Available</p>
            @else
            <p><strong>Status: </strong>Unavailable</p>
        @endif
        <p><strong>Available For:</strong> <span id="countdown" data-due-date="{{ $borrow->due_date }}"></span></p>
        <p><a href="{{ asset('pdfs/' . $book->pdf_path) }}" target="_blank">Download PDF</a></p>
    </div>
    <script src="{{ asset('adminkit/js/app.js') }}"></script>
</x-user_page>