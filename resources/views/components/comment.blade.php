@props(['model'])

@php
    $usernames = Auth::check() ? \App\Models\User::pluck('username') : collect([]);
    $placeholder = class_basename($model) === 'Thread' ? 'Join the conversation...' : 'Write your comment...';
    $placeholder_button = class_basename($model) === 'Thread' ? 'Post' : 'Comment';
@endphp

<div class="mx-auto px-4 bg-white border">
    <div class="flex justify-center items-center">
        <h4 class="text-center pt-5">Discussion</h4>
    </div>
    @guest
        <h5 class="text-center mb-6">Please <a href="{{ route('login') }}">Sign in</a> to comment.</h5>
    @endguest
    @auth
        <form class="mb-6" action="{{ route('comments.store') }}" method="POST" id="main-comment-form">
            @csrf
            <input type="hidden" name="commentable_id" value="{{ $model->id }}">
            <input type="hidden" name="commentable_type" value="{{ get_class($model) }}">

            <textarea name="body" id="main-comment-textarea" style="border-radius: 1.5rem; font-size: 1rem;" class="form-control mentionable mb-2 py-3" rows="1" placeholder="{{ $placeholder }}"></textarea>

            <div class="action-buttons hidden flex gap-2 mt-2">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg px-5 py-2.5">{{ $placeholder_button }}</button>
                <button type="button" id="cancel-main-comment" class="text-gray-700 bg-gray-200 hover:bg-gray-300 focus:outline-none rounded-lg px-5 py-2.5">Cancel</button>
            </div>
        </form>
    @endauth

    @foreach($model->comments->where('parent_id', null) as $comment)
        <x-comment-item :comment="$comment" />
    @endforeach
</div>

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/tributejs@5.1.3/dist/tribute.css" />
<script src="https://unpkg.com/tributejs@5.1.3/dist/tribute.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let users = @json($usernames);

        let tribute = new Tribute({
            trigger: '@',
            values: users.map(name => ({ key: name, value: name })),
            selectTemplate: function (item) {
                return `@${item.original.value}`;
            }
        });

        document.querySelectorAll('.mentionable').forEach((input) => {
            tribute.attach(input);
        });

        // Main Comment Form Logic
        const textarea = document.getElementById('main-comment-textarea');
        const actionButtons = document.querySelector('.action-buttons');
        const cancelBtn = document.getElementById('cancel-main-comment');

        textarea.addEventListener('focus', () => {
            actionButtons.classList.remove('hidden');
        });

        cancelBtn.addEventListener('click', () => {
            textarea.value = '';
            actionButtons.classList.add('hidden');
        });

        // Optional: if user clicks outside, close it
        document.addEventListener('click', function(e) {
            if (!document.getElementById('main-comment-form').contains(e.target)) {
                textarea.value = '';
                actionButtons.classList.add('hidden');
            }
        });
    });
</script>
@endpush
