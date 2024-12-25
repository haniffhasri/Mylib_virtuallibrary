<x-admin_page>
    <h1>Update Book</h1>
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
            <input type="text" id="genre" name="genre" class="form-control" value="{{ $book->genre }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="format">Format</label>
            <input type="text" id="format" name="format" class="form-control" value="{{ $book->format }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="status">Status</label>
            <input type="checkbox" id="status" name="status" value="1" class="form-check-input" 
                {{ $book->status ? 'checked' : '' }}>
            <label for="status" class="form-check-label">Available</label>
        </div>        
        <div class="form-group mb-3">
            <label for="book_publication_date">Publication Date</label>
            <input type="date" id="book_publication_date" name="book_publication_date" class="form-control" value="{{ $book->book_publication_date }}" required>
        </div>
        <div class="form-group mb-3">
            <label for="pdf_path" class="form-label">Upload PDF</label>
            <input type="file" name="pdf_path" id="pdf_path" class="form-control" accept="application/pdf" value="{{ $book->pdf_path }}">
        </div>

        <div class="form-group mb-3">
            <label for="image_path" class="form-label">Upload Cover Image</label>
            <input type="file" name="image_path" id="image_path" class="form-control" accept="image/*" value="{{ $book->image_path }}">
        </div>
        <!-- Repeat for other fields -->
        <button type="submit" class="btn btn-primary" value="Update">Submit Book</button>

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        @endif
    </form> 
</x-admin_page>