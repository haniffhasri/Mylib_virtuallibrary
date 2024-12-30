<style>
    @tailwind utilities;
</style>
@if (Auth::check())
    @php
        $usertype = Auth::user()->usertype;
    @endphp

@if ($usertype == 'admin')
    <x-admin_page>
        <div class="book-container-list">
            <h2>Available Books</h2>
            <ul class="book-list admin">
                @foreach ($book as $book_item)
                <li>
                    <x-card href="{{ route('book.show', $book_item->id) }}">
                        <div class="card-list">
                            <h3>{{ $book_item->book_title }}</h3>
                            <div>
                                <a class="btn btn-danger" href="{{ route('book.destroy', $book_item->id) }}">Delete</a>
                                <a class="btn btn-info" href="{{ route('book.edit', $book_item->id) }}">Update</a>
                            </div>
                        </div>
                    </x-card>
                </li>
                @endforeach        
            </ul>
    
            {{ $book->links() }}
        </div>
    </x-admin_page>
@elseif ($usertype == 'user')
    <x-layout>
        <div class="book-container-list">
            <h2 style="color:white;">Available Books</h2>
            <ul class="book-list">
                @foreach ($book as $book_item)
                <li>
                    <x-card href="{{ route('book.show', $book_item->id) }}">
                        <div class="card-list">
                            <h3>{{ $book_item->book_title }}</h3>
                            @if($borrow->contains($book_item->id)) <!-- Check if the user has borrowed this book -->
                                <a class="btn btn-primary" href="{{ asset('pdfs/' . $book_item->pdf_path) }}" target="_blank">Read PDF</a>
                            @else
                                <a class="btn btn-primary" href="{{ route('borrow_book', $book_item->id) }}">Borrow</a>
                            @endif
                        </div>
                    </x-card>
                </li>
                @endforeach        
            </ul>
    
            {{ $book->links() }}
        </div>
    </x-layout>
@endif

@else
    <x-layout>
        <div class="book-container-list">
            <h2 style="color:white;">Available Books</h2>
            <ul class="book-list">
                @foreach ($book as $book_item)
                <li>
                    <x-card href="{{ route('book.show', $book_item->id) }}">
                        <div class="card-list">
                            <h3>{{ $book_item->book_title }}</h3>
                            <a class="btn btn-primary" href="{{ route('login') }}">Borrow</a>
                        </div>
                    </x-card>
                </li>
                @endforeach        
            </ul>

            {{ $book->links() }}
        </div>
    </x-layout>
@endif