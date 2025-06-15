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
        <h4>Notifications</h4>

        <!-- Alert Messages -->
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    @if(session('status'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    <!-- Notifications List -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <ul class="divide-y divide-gray-200 list-none">
            @forelse($notifications as $notification)
                <li class="{{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }} hover:bg-gray-50 transition duration-150">
                    <div class="px-4 py-4 sm:px-6 flex justify-between items-center">
                        <div class="text-sm text-gray-800">
                            {{ $notification->data['message'] }}
                            <p class="text-xs text-gray-500 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <a href="{{ route('notifications.read', $notification->id) }}" 
                           class="px-3 py-1 border border-green-500 rounded-md text-sm font-medium 
                                  {{ $notification->read_at ? 'text-green-600 hover:bg-green-50' : 'bg-green-100 text-green-700 hover:bg-green-200' }}
                                  transition duration-200">
                            {{ $notification->read_at ? 'View' : 'Mark as Read & View' }}
                        </a>
                    </div>
                </li>
            @empty
                <li class="px-4 py-6 sm:px-6 text-center text-gray-500">
                    No notifications found.
                </li>
            @endforelse
        </ul>
    </div>
</div>
@endsection