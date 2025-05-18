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
<h4>Forum List</h4>
<form method="GET" action="{{ route('forum.index') }}" class="mb-4">
    <label for="sort">Sort by:</label>
    <select name="sort" id="sort" onchange="this.form.submit()">
        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
    </select>
</form>
<ul class="forum-list list-none">
    @foreach ($forum as $forums)
        <li>
            <x-card href="{{ route('forum.show', $forums->slug) }}">
                <div class="card-list">
                    <h4>{{ $forums->forum_title }}</h4>
                </div>
            </x-card>
        </li>
    @endforeach
</ul>
@endsection