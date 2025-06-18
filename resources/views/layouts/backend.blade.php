@php use Illuminate\Support\Facades\Auth; @endphp

@if(auth()->user()?->usertype === 'admin' || auth()->user()?->usertype === 'librarian')
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>{{ config('app.name', 'Mylib') }}</title>

	@vite(['resources/sass/app.scss', 'resources/js/app.js'])

	{{-- logo --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png')}}" sizes="96x96" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png')}}" />

	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
	<script src="https://unpkg.com/lenis@1.3.4/dist/lenis.min.js"></script> 
	<script src="//unpkg.com/alpinejs" defer></script>
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
						<span class="align-middle">Dashboard</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('book.index') }}">
						<span class="align-middle">Book List</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('admin.borrow') }}">
						<span class="align-middle">Borrow List</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('wishlist.index') }}">
						<span class="align-middle">Wish List</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('book.create') }}">
						<span class="align-middle">Insert New Book</span>
					</a>
				</li>
				<li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('forum.index') }}">
						<span class="align-middle">Forum List</span>
					</a>
				</li>
				{{-- <li class="sidebar-item">
					<a class="sidebar-link" href="{{ route('forum.create') }}">
						<span class="align-middle">Create a Forum</span>
					</a>
				</li> --}}
				@if(Auth::user()?->usertype === 'admin')
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('admin.user') }}">
							<span class="align-middle">User List</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('analytics.index') }}">
							<span class="align-middle">Analytics</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link"href="{{ route('contact-us.show', ['id' => 1]) }}">
							<span class="align-middle">Contact Us</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('support.index') }}">
							<span class="align-middle">Support View</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('backup.index') }}">
							<span class="align-middle">Backup</span>
						</a>
					</li>
					<li class="sidebar-item">
						<a class="sidebar-link" href="{{ route('admin.codes.index') }}">
							<span class="align-middle">Librarian code generator</span>
						</a>
					</li>
				@endif
			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle"><i class="hamburger align-self-center"></i></a>

				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
						<!-- Notifications -->
						<div class="relative" x-data="{ open: false }">
							<button @click="open = !open" class="p-1 rounded-full text-gray-600 pink hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out relative">
								<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
								</svg>
								@if($headerNotifications->count() > 0)
									<span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">{{ $headerNotifications->count() }}</span>
								@endif
							</button>
							
							<div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-72 md:w-96 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50">
								<div class="py-1">
									@forelse($headerNotifications as $notification)
										<div class="px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200 flex justify-between items-center {{ $notification->read_at ? '' : 'bg-indigo-50' }}">
											<div>{{ $notification->data['message'] }}</div>
											<a href="{{ route('notifications.read', $notification->id) }}" class="text-xs px-2 py-1 rounded bg-indigo-100 text-indigo-800 hover:bg-indigo-200 transition-colors duration-200">
												{{ $notification->read_at ? 'View' : 'Mark as Read' }}
											</a>
										</div>
									@empty
										<div class="px-4 py-3 text-sm text-gray-700">No notifications found</div>
									@endforelse
								</div>
								<div class="py-1">
									<a href="{{ route('notifications.index') }}" class="block px-4 py-2 text-sm text-center text-indigo-700 hover:bg-gray-100 transition-colors duration-200">View All Notifications</a>
								</div>
							</div>
						</div>

						<!-- Profile dropdown -->
						<div class="relative ml-3" x-data="{ open: false }">
							<div>
								<button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out" id="user-menu">
									<img class="h-8 w-8 rounded-full object-cover" src="{{ asset('profile_picture/' . Auth::user()->profile_picture) }}" alt="{{ Auth::user()->username }}">
									<span class="ml-2 text-gray-700 font-medium hidden lg:inline">{{ Auth::user()->username }}</span>
									<svg class="ml-1 h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
									</svg>
								</button>
							</div>
							
							<div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
								<div class="py-1">
									<a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">Dashboard</a>
									<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-200">Logout</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
										@csrf
									</form>
								</div>
							</div>
						</div>
					</ul>
				</div>
			</nav>

			<main class="content">
				@yield('content')
			</main>
		</div>
	</div>

	@stack('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fetchNotifications = async () => {
                try {
                    const response = await fetch('/notifications/fetch');
                    const data = await response.json();

                    const notifications = data.notifications;
                    const notifList = document.getElementById('notification-list');
                    const badge = document.getElementById('notification-badge');

                    notifList.innerHTML = '';

                    notifications.forEach(notification => {
                        const notifItem = document.createElement('div');
                        notifItem.className = 'dropdown-item d-flex justify-content-between align-items-center bg-light';
                        notifItem.innerHTML = `
                            <div>${notification.data.message}</div>
                            <a href="/notifications/read/${notification.id}" class="btn btn-sm btn-outline-success">Mark as Read & View</a>
                        `;
                        notifList.appendChild(notifItem);
                    });

                    badge.textContent = data.count;
                    badge.classList.toggle('d-none', data.count === 0);
                } catch (error) {
                    console.error('Failed to load notifications', error);
                }
            };

            // Initial fetch
            fetchNotifications();

            // Optional: Refresh every 60 seconds
            setInterval(fetchNotifications, 60000);
        });
    </script>
    <script>
      const lenis = new Lenis({
        duration: 1.2,       // scroll speed (lower = faster)
        easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // easing function
        smooth: true,
        smoothTouch: true,
      })

      function raf(time) {
        lenis.raf(time)
        requestAnimationFrame(raf)
      }

      requestAnimationFrame(raf)
    </script>
	<script>
		document.addEventListener('DOMContentLoaded', function () {
			// Grab all delete buttons with the show-confirm class
			const deleteButtons = document.querySelectorAll('.show-confirm');

			deleteButtons.forEach(button => {
				button.addEventListener('click', function (e) {
					e.preventDefault(); // prevent default form submission

					const form = this.closest('form');

					Swal.fire({
						title: 'Are you sure?',
						text: "This action cannot be undone.",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#d33',
						cancelButtonColor: '#3085d6',
						confirmButtonText: 'Yes, delete it!',
						cancelButtonText: 'Cancel'
					}).then((result) => {
						if (result.isConfirmed) {
							form.submit(); // submit the form only if confirmed
						}
					});
				});
			});
		});
	</script>
	<script type="text/javascript">
    $(function () {
      var $window = $(window),
        win_height_padded = $window.height() * 0.8;

      $window.on('scroll', setInterval(maskinleftload, 100));

      function maskinleftload() {
        var scrolled = $window.scrollTop();
        $('.element-fade-up:not(.animated)').each(function () {
          var $this = $(this),
            offsetTop = $this.offset().top;
          if (scrolled + win_height_padded > offsetTop) {
            if ($this.data('timeout')) {
              window.setTimeout(function () {
                $this.addClass('triggered ' + $this.data('animation'));
              }, parseInt($this.data('timeout'), 10));
            } else {
              $this.addClass('triggered ' + $this.data('animation'));
            }
          }
        });
      }
    });
  </script>
  <script>
    if ($('div').is('.accordion')) {
      // Initially, hide all accordion content
      $('.accordion-content').hide();

      // When an accordion header is clicked
      $('.accordion-header').click(function () {
        // Toggle the content
        var content = $(this).next('.accordion-content');
        content.slideToggle(200);

        // Toggle the active class to change the style
        $(this).toggleClass('active');

        // Close other open accordions
        $('.accordion-content').not(content).slideUp(200);
        $('.accordion-header').not(this).removeClass('active');
      });
    }

    $('.timeline-tab .inner').on('click', function () {
      $('.timeline-tab .inner').removeClass('active');
      $(this).addClass('active');

      let currentActive = $(this).data('tab');
      $('.timeline-content .content-holder').removeClass('active');
      $('.timeline-content .content-holder.' + currentActive).addClass('active');
    });

    if ($(window).width() < 767) {
      $('.timeline-tab').click(function () {
        $('.inner-holder').toggleClass('active');
      });

      $('.inner-holder h3').click(function () {
        let currentActive = $(this).text();
        $('.timeline-tab > .mobile > h3').text(currentActive);
      });
    }
  </script>
</body>
</html>
@endif