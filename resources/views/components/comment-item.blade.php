@props(['comment', 'depth' => 1])

@php
    $maxDepth = $comment->commentable_type === 'App\\Models\\Thread' ? 5 : 3;
    $canNest = $depth < $maxDepth;
    $isFirstDepth = $depth === 1;
    $isBook = $comment->commentable_type === 'App\\Models\\Book';
    $showBorderComment = !$isFirstDepth && !$isBook;
@endphp

<div id="comment-{{ $comment->id }}" class="{{ $showBorderComment ? 'border-comment' : '' }} {{ $canNest ? 'ms-5' : '' }} {{ $isFirstDepth ? 'mt-3 p-2 bg-white rounded' : '' }} comment">
    <div>
        <strong>{{ $comment->user->name }}</strong> said:
        <p>{!! nl2br(e($comment->body)) !!}</p>
    </div>

    @auth
        @if(Auth::id() === $comment->user_id || Auth::user()->usertype === 'admin')
            <div class="dropdown three-dot-dropdown">
                <a class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                        <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                    </svg>
                    <span class="sr-only">Comment settings</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('comments.delete', $comment->id) }}">Delete</a>
                    <a class="dropdown-item toggle-edit" data-comment-id="{{ $comment->id }}">Update</a>
                </div>
            </div>

            {{-- Edit Form --}}
            <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="edit-form mt-2" id="edit-form-{{ $comment->id }}" style="display: none;">
                @csrf
                @method('POST')
                <div class="form-group">
                    <textarea name="body" class="form-control mentionable" rows="3">{{ $comment->body }}</textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-1">Save</button>
                <button type="button" class="btn btn-sm btn-secondary mt-1 cancel-edit" data-comment-id="{{ $comment->id }}">Cancel</button>
            </form>
        @endif

        {{-- Reply Toggle Button --}}
        <button type="button" class="btn btn-sm btn-link toggle-reply mt-3 mb-2 relative" style="top:-1rem" data-comment-id="{{ $comment->id }}" data-username="{{ '@' . $comment->user->username }}"><b>Reply</b></button>

        {{-- Reply Form (Initially Hidden) --}}
        <form action="{{ route('comments.store') }}" method="POST" class="{{ $canNest ? 'ms-4' : '' }} mt-2 mb-3" id="reply-form-{{ $comment->id }}" style="display: none;">
            @csrf
            <input type="hidden" name="commentable_id" value="{{ $comment->commentable_id }}">
            <input type="hidden" name="commentable_type" value="{{ get_class($comment->commentable) }}">
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <textarea name="body" class="form-control mentionable my-2" rows="3" placeholder="Write your reply..."></textarea>
            <button type="submit" class="btn btn-sm btn-secondary">Reply</button>
            <button type="button" class="btn btn-sm btn-light cancel-reply" data-comment-id="{{ $comment->id }}">Cancel</button>
        </form>
    @endauth

    {{-- Nested Replies --}}
    @foreach ($comment->replies as $reply)
        <x-comment-item :comment="$reply" :depth="min($depth + 1, $maxDepth)" />
    @endforeach
</div>

