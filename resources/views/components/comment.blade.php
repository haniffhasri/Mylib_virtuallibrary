@props(['model'])

@php
    $usernames = Auth::check() ? \App\Models\User::pluck('username') : collect([]);
@endphp

<div class="max-w-2xl mx-auto px-4">
    <div class="flex justify-center items-center">
        <h4 class="text-center">Discussion</h4>
    </div>
    @guest
        <h5 class="text-center mb-6">Please <a href="{{ route('login') }}">Sign in</a> to comment.</h5>
    @endguest
    @auth
        <form class="mb-6" action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="commentable_id" value="{{ $model->id }}">
            <input type="hidden" name="commentable_type" value="{{ get_class($model) }}">

            <textarea name="body" class="form-control mentionable mb-3" rows="4" placeholder="Write your comment..."></textarea>
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg w-full sm:w-auto px-5 py-2.5 text-center">Comment</button>
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
    });
</script>
@endpush
