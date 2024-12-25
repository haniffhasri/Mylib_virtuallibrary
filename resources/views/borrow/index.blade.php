<x-user_page>
    @if(session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">X</button>
        {{ session()->get('message') }}
    </div>
    @endif
    <div>
        <h2>Borrowed Books</h2>
        @foreach($borrow as $borrowed)
                <li>
                    <x-card href="{{ route('book.show', $borrowed->book_id) }}">
                        <p>Book: {{ $borrowed->book->book_title }}</p>
                    </x-card>
                </li>
        @endforeach
        
    </div>
</x-user_page>