@php
    if (Auth::check()) {
        $usertype = Auth::user()->usertype;
        $layout = ($usertype === 'admin' || $usertype === 'librarian') ? 'layouts.backend' : 'layouts.app';
    } else {
        $layout = 'layouts.app';
    }
@endphp

@extends($layout)

@section('content')
<div class="container">

    <!-- Thread Header -->
    <div class="mb-4 p-4 bg-white shadow-xl">
        <h4>{{ $thread->thread_title }}</h4>
        <p class="text-muted">
            Posted by {{ $thread->user->name }} • {{ $thread->created_at->diffForHumans() }}
        </p>
        <p>{{ $thread->thread_body }}</p>

        @auth
            @if(auth()->id() === $thread->user_id)
                <div class="mt-2">
                    <a href="{{ route('forum.threads.edit', $thread->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <a href="{{ route('forum.threads.delete', $thread->id) }}" class="btn btn-sm btn-danger">Delete</a>
                </div>
            @endif
        @endauth
    </div>

    <!-- Comments Section -->
    <div class="mt-5">
        <x-comment :model="$thread" />
    </div>

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('click', function (e) {
        const editBtn = e.target.closest('.toggle-edit');
        const cancelBtn = e.target.closest('.cancel-edit');
        const replyBtn = e.target.closest('.toggle-reply');
        const cancelReplyBtn = e.target.closest('.cancel-reply');

        if (editBtn) {
            const commentId = editBtn.dataset.commentId;
            const form = document.getElementById('edit-form-' + commentId);
            if (form) {
                form.style.display = (form.style.display === 'none') ? 'block' : 'none';
            }
        }

        if (cancelBtn) {
            const commentId = cancelBtn.dataset.commentId;
            const form = document.getElementById('edit-form-' + commentId);
            if (form) {
                form.style.display = 'none';
            }
        }

        if (replyBtn) {
            const commentId = replyBtn.dataset.commentId;
            const form = document.getElementById('reply-form-' + commentId);
            if (form) {
                form.style.display = (form.style.display === 'none') ? 'block' : 'none';
            }
        }

        if (cancelReplyBtn) {
            const commentId = cancelReplyBtn.dataset.commentId;
            const form = document.getElementById('reply-form-' + commentId);
            if (form) {
                form.style.display = 'none';
            }
        }
    });
</script>S
@endpush
