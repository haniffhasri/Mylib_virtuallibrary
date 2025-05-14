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
    {{-- @if($notifications->isEmpty())
        <p>No new notifications.</p>
    @else
        @foreach($notifications as $note)
            <div>
                {{ $note->data['message'] }}
                <a href="{{ route('notifications.read', $note->id) }}">View</a>
            </div>
        @endforeach
    @endif --}}
@endsection
