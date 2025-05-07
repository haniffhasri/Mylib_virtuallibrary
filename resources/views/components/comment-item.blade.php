@props(['comment', 'depth' => 1])

@php
    $maxDepth = $comment->commentable_type === 'App\\Models\\Thread' ? 5 : 3;
    $canNest = $depth < $maxDepth;
    $isFirstDepth = $depth === 1;
@endphp

<div class="{{ $canNest ? 'ms-5' : '' }}{{ $isFirstDepth ? 'mt-3 border p-2 bg-light rounded' : '' }}">
    <div>
        <strong>{{ $comment->user->name }}</strong> said:
        <p>{!! highlightMentions($comment->body) !!}</p>
    </div>
    @auth
        @if(Auth::id() === $comment->user_id || Auth::user()->usertype === 'admin')
            <div class="mt-2">
                <a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-sm btn-danger">Delete</a>
            </div>
        @endif
    @endauth
    @auth
        <!-- Always show reply form, even if depth limit is reached -->
        <form action="{{ route('comments.store') }}" method="POST" class="{{ $canNest ? 'ms-4' : '' }}">
            @csrf
            <input type="hidden" name="commentable_id" value="{{ $comment->commentable_id }}">
            <input type="hidden" name="commentable_type" value="{{ get_class($comment->commentable) }}">
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">

            <div contenteditable="true" class="form-control my-2 mention-editor" style="min-height: 100px;"></div>
            <textarea name="body" class="hidden-comment-input" style="display: none;"></textarea>
            <button type="submit" class="btn btn-sm btn-secondary">Reply</button>
        </form>
    @endauth
    <div class="NestedDepth"></div>

    <!-- Replies -->
    @foreach ($comment->replies as $reply)
        <x-comment-item :comment="$reply" :depth="min($depth + 1, $maxDepth)" />
    @endforeach
</div>
