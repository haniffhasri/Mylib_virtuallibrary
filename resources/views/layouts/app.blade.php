<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mylib') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <a class="nav-link"href="{{ route('book.index') }}">Book List</a>
                        <a class="nav-link"href="{{ route('forum.index') }}">Forum List</a>
                        <a class="nav-link" href="{{ route('contact-us.show', ['id' => 1]) }}">Contact Us</a>
                        <a class="nav-link" href="{{ route('support.index') }}">Support</a>
                        @auth
                            <a class="nav-link" href="{{ route('forum.create') }}">Create a Forum</a>
                            <a class="nav-link" href="{{ route('notifications.index') }}">Notifications</a>
                            @if(Auth::user()?->usertype === 'user')
                            <a class="nav-link" href="{{ route('borrow.index') }}">Borrowed Books</a>
                            @elseif(Auth::user()?->usertype === 'admin' || Auth::user()?->usertype === 'librarian')
                                <a class="nav-link" href="{{ route('borrow.show') }}">Borrow List</a>
                                <a class="nav-link" href="{{ route('book.create') }}">Insert New Book</a>
                            @elseif(Auth::user()?->usertype === 'admin')
                                <a class="nav-link" href="{{ route('admin.user') }}">User List</a>
                                <a class="nav-link" href="{{ route('analytics.index') }}">Analytics</a>
                            @endif
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Notifications</a>

							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
								{{-- @forelse($notifications as $notification)
                                    <div class="list-group-item d-flex justify-content-between align-items-center {{ $notification->read_at ? '' : 'bg-light' }}">
                                        <div>
                                            {{ $notification->data['message'] }}
                                        </div>
                                        <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-sm btn-outline-success">
                                            {{ $notification->read_at ? 'View' : 'Mark as Read & View' }}
                                        </a>
                                    </div>
                                @empty
                                    <p class="list-group-item">No notifications found.</p>
                                @endforelse --}}
							</div>
						</li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 px-6">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
