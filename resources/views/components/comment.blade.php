<div class="comment">
    @if(Auth::check())
        <form action="{{ route('comments.store', $book->id) }}" method="POST">
            @csrf
            <textarea name="body" class="form-control my-2" rows="3" placeholder="Add a comment..."></textarea>
            <button type="submit" class="btn btn-primary">Comment</button>
        </form>
    @endif

    @foreach ($book->comments as $comment)
        <div class="mt-3 border p-2 bg-light rounded">
            <strong>{{ $comment->user->name }}</strong> said:
            <p>{{ $comment->body }}</p>

            <!-- Reply form -->
            @if(Auth::check())
                <form action="{{ route('comments.store', $book->id) }}" method="POST" class="ms-4">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <textarea name="body" class="form-control mb-2" rows="2" placeholder="Reply..."></textarea>
                    <button type="submit" class="btn btn-sm btn-secondary">Reply</button>
                </form>
            @endif

            <!-- Replies -->
            @foreach ($comment->replies as $reply)
                <div class="ms-5 mt-2 bg-white border rounded p-2">
                    <strong>{{ $reply->user->name }}</strong> replied:
                    <p>{{ $reply->body }}</p>
                </div>
            @endforeach
        </div>
    @endforeach
</div>