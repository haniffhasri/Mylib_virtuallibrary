@php use Illuminate\Support\Facades\Auth; @endphp

@if(auth()->user()?->usertype === 'admin' || auth()->user()?->usertype === 'librarian')
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>{{ config('app.name', 'Mylib') }}</title>

	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
	<div class="wrapper" id="app">
		<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="/">
          <span class="align-middle">Mylib</span>
        </a>
			<ul class="sidebar-nav">
				<li class="sidebar-header">
					Pages
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('dashboard') }}">
						<i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('book.index') }}">
						<i class="align-middle" data-feather="book"></i> <span class="align-middle">Book List</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('borrow.show') }}">
						<i class="align-middle" data-feather="user-plus"></i> <span class="align-middle">Borrow List</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('book.create') }}">
						<i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Insert New Book</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('forum.index') }}">
						<i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Forum List</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('forum.create') }}">
						<i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Create a Forum</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('notifications.index') }}">
						<i class="align-middle" data-feather="log-in"></i> <span class="align-middle">Notifications</span>
					</a>
				</li>
				@if(auth()->user()?->usertype === 'admin')
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('admin.user') }}">
							<i class="align-middle" data-feather="user"></i> <span class="align-middle">User List</span>
						</a>
					</li>
				{{-- @elseif(auth()->user()?->usertype === 'librarian') --}}
				@endif
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle"><i class="hamburger align-self-center"></i></a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<li class="nav-item dropdown">
							<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Notifications</a>

							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
								@if($notifications->isEmpty())
									<p>No new notifications.</p>
								@else
									@foreach($notifications as $note)
										<div>
											{{ $note->data['message'] }}
											<a href="{{ $note->data['url'] }}">View</a>
										</div>
									@endforeach
								@endif
							</div>
						</li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown"><i class="align-middle" data-feather="settings"></i></a>
							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
								<span class="text-dark">{{ Auth::user()->name }}</span>
							</a>
							<div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
								<a class="dropdown-item" href="{{ route('book.index') }}">Book List</a>
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
					</ul>
				</div>
			</nav>

			<main class="content">
				@yield('content')
			</main>
		</div>
	</div>

	@stack('scripts')
</body>
</html>
@endif