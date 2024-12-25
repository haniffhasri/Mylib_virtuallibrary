@if (Auth::check())
    @php
        $usertype = Auth::user()->usertype;
    @endphp

    @if ($usertype == 'admin')
        <x-layout>
            <div class="book-show">
                <h2 style="color: white;">{{ $book->book_title }}</h2>
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
                <p><a href="{{ asset('pdfs/' . $book->pdf_path) }}" target="_blank">Read PDF</a></p>
            </div>
        </x-layout>
    @elseif ($usertype == 'user')
        <x-layout>
            <div class="book-show">
                <h2 style="color: white;">{{ $book->book_title }}</h2>
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
                @if($borrow->contains('book_id', $book->id))
                    <a class="btn btn-primary" href="{{ asset('pdfs/' . $book->pdf_path) }}" target="_blank">Read PDF</a>
                    @else
                    <a class="btn btn-primary" href="{{ route('borrow_book', $book->id) }}">Borrow</a>
                @endif
            </div>
        </x-layout>
    @endif

@else
    <x-layout>
        <div class="book-show">
            <h2 style="color: white;">{{ $book->book_title }}</h2>
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
            <a class="btn btn-primary" href="{{ route('login') }}">Borrow</a>
        </div>
    </x-layout>
@endif


