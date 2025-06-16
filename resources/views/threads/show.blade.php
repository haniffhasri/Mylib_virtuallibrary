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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle Update Form
        document.querySelectorAll('.toggle-edit').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const commentId = this.dataset.commentId;
                const form = document.getElementById(`edit-form-${commentId}`);
                form.style.display = form.style.display === 'none' ? 'block' : 'none';
            });
        });

        // Cancel Update
        document.querySelectorAll('.cancel-edit').forEach(button => {
            button.addEventListener('click', function () {
                const commentId = this.dataset.commentId;
                const form = document.getElementById(`edit-form-${commentId}`);
                form.style.display = 'none';
            });
        });

        // Toggle Reply Form
        document.querySelectorAll('.toggle-reply').forEach(button => {
            button.addEventListener('click', function () {
                const commentId = this.dataset.commentId;
                const username = this.dataset.username;
                const form = document.getElementById(`reply-form-${commentId}`);
                const textarea = form.querySelector('textarea');

                // Show the form
                const isHidden = form.style.display === 'none';
                form.style.display = isHidden ? 'block' : 'none';

                if (isHidden && textarea.value.trim() === '') {
                    textarea.value = `${username} `;
                    textarea.focus();
                    textarea.setSelectionRange(textarea.value.length, textarea.value.length);
                }
            });
        });

        // Cancel Reply
        document.querySelectorAll('.cancel-reply').forEach(button => {
            button.addEventListener('click', function () {
                const commentId = this.dataset.commentId;
                const form = document.getElementById(`reply-form-${commentId}`);
                form.style.display = 'none';
            });
        });
    });
</script>
@endpush
@endsection