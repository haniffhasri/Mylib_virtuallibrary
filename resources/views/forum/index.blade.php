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
<ul class="book-list">
    @foreach ($forum as $forums)
        <li>
            <x-card href="{{ route('forum.show', $forums->slug) }}">
                <div class="card-list">
                    <h3>{{ $forums->forum_title }}</h3>
                </div>
            </x-card>
        </li>
    @endforeach
</ul>
@endsection