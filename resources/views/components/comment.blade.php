@props(['model']) {{-- model = $book or $thread --}}
@php
    $usernames = Auth::check() ? \App\Models\User::pluck('name') : collect([]);
    function highlightMentions($text) {
        return preg_replace('/@([\w\s]+)/', '<span style="color: blue;">@$1</span>', e($text));
    }
@endphp

<div class="comment">
    @if(Auth::check())
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="commentable_id" value="{{ $model->id }}">
            <input type="hidden" name="commentable_type" value="{{ get_class($model) }}">

            <div contenteditable="true" class="form-control my-2 mention-editor" style="min-height: 100px;"></div>
            <textarea name="body" class="hidden-comment-input" style="display: none;"></textarea>
            <button type="submit" class="btn btn-primary">Comment</button>
        </form>
    @endif

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
                return `@${item.original.value}`; // just insert plain @mention
            }
        });

        document.querySelectorAll('.mention-editor').forEach((editor) => {
            tribute.attach(editor);

            let form = editor.closest('form');
            let hiddenInput = form.querySelector('.hidden-comment-input');

            form.addEventListener('submit', function () {
                const plainText = editor.innerText;
                hiddenInput.value = plainText;
            });
        });
    });
</script>
@endpush


