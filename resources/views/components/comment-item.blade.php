@props(['comment', 'depth' => 1])

@php
    $maxDepth = $comment->commentable_type === 'App\\Models\\Thread' ? 5 : 3;
    $canNest = $depth < $maxDepth;
    $isFirstDepth = $depth === 1;
@endphp

<div class="{{ $canNest ? 'ms-5' : '' }}{{ $isFirstDepth ? 'mt-3 border p-2 bg-light rounded' : '' }}">
    <div>
        <strong>{{ $comment->user->name }}</strong> said:
        <p>{!! ($comment->body) !!}</p>
    </div>
    @auth
        @if(Auth::id() === $comment->user_id || Auth::user()->usertype === 'admin')
            <div class="mt-2">
                <a href="{{ route('comments.delete', $comment->id) }}" class="btn btn-sm btn-danger">Delete</a>
                <button type="button" class="btn btn-sm btn-primary toggle-edit" data-comment-id="{{ $comment->id }}">Update</button>
            </div>
            <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="edit-form mt-2" id="edit-form-{{ $comment->id }}" style="display: none;">
                @csrf
                @method('POST')
                <div class="form-group">
                    <textarea name="body" class="form-control" rows="3">{{ $comment->body }}</textarea>
                </div>
                <button type="submit" class="btn btn-sm btn-success mt-1">Save</button>
                <button type="button" class="btn btn-sm btn-secondary mt-1 cancel-edit" data-comment-id="{{ $comment->id }}">Cancel</button>
            </form>
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

@section('scripts')
<script> 
    document.addEventListener('DOMContentLoaded', function () { 
        document.querySelectorAll('.toggle-edit').forEach(button => { 
            button.addEventListener('click', function () { 
                const commentId = this.dataset.commentId; 
                const form = document.getElementById('edit-form-' + commentId); 
                form.style.display = (form.style.display === 'none') ? 'block' : 'none'; 
            }); 
        }); 
        document.querySelectorAll('.cancel-edit').forEach(button => { 
            button.addEventListener('click', function () { 
                const commentId = this.dataset.commentId; 
                const form = document.getElementById('edit-form-' + commentId); 
                form.style.display = 'none'; 
            }); 
        }); 
    }); 
</script>
@endsection