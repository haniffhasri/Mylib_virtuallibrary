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
        <h2>Notifications</h2>

        <form action="{{ route('notifications.readAll') }}" method="POST">
            @csrf
            <button class="btn btn-sm btn-primary mb-3">Mark All as Read</button>
        </form>

        <ul class="list-group">
            @forelse($notifications as $notification)
                <li class="list-group-item d-flex justify-content-between align-items-center {{ $notification->read_at ? '' : 'bg-light' }}">
                    <div>
                        {{ $notification->data['message'] }}
                    </div>
                    <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-sm btn-outline-success">
                        {{ $notification->read_at ? 'View' : 'Mark as Read & View' }}
                    </a>
                </li>
            @empty
                <li class="list-group-item">No notifications found.</li>
            @endforelse
        </ul>
    </div>
@endsection
