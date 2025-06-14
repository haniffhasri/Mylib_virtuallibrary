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
<div class="container mx-auto px-4 py-6">

    <!-- Thread Header -->
    <div class="mb-6 p-6 bg-white rounded-lg shadow-md">
        <h4 class="text-2xl font-bold text-gray-800 mb-2">{{ $thread->thread_title }}</h4>
        <p class="text-gray-500 text-sm mb-4">
            Posted by <span class="font-medium">{{ $thread->user->name }}</span> • {{ $thread->created_at->diffForHumans() }}
        </p>
        <p class="text-gray-700 mb-4">{{ $thread->thread_body }}</p>

        @auth
            @if(auth()->id() === $thread->user_id)
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('forum.threads.edit', $thread->id) }}" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded transition duration-200">Edit</a>
                    <a href="{{ route('forum.threads.delete', $thread->id) }}" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm font-medium rounded transition duration-200 show-confirm">Delete</a>
                </div>
            @endif
        @endauth
    </div>

    <!-- Comments Section -->
    <div class="mt-8">
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
                form.classList.toggle('hidden');
            }
        }

        if (cancelBtn) {
            const commentId = cancelBtn.dataset.commentId;
            const form = document.getElementById('edit-form-' + commentId);
            if (form) {
                form.classList.add('hidden');
            }
        }

        if (replyBtn) {
            const commentId = replyBtn.dataset.commentId;
            const form = document.getElementById('reply-form-' + commentId);
            if (form) {
                form.classList.toggle('hidden');
            }
        }

        if (cancelReplyBtn) {
            const commentId = cancelReplyBtn.dataset.commentId;
            const form = document.getElementById('reply-form-' + commentId);
            if (form) {
                form.classList.add('hidden');
            }
        }
    });
</script>
@endpush