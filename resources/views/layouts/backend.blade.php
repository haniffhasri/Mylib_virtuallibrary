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
						<li class="nav-item dropdown flex items-center">
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Notifications
                            @if($headerNotifications->count() > 0)
                              <span id="notification-badge" class="badge bg-danger">{{ $headerNotifications->count() }}</span>
                            @else
                              <span id="notification-badge" class="badge bg-danger d-none">0</span>
                            @endif
                          </a>

                          <div id="notification-list" class="dropdown-menu w-max notification-dropdown dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @forelse($headerNotifications as $notification)
                              <div class="dropdown-item d-flex justify-content-between align-items-center {{ $notification->read_at ? '' : 'bg-light' }}">
                                  <div>{{ $notification->data['message'] }}</div>
                                  <a href="{{ route('notifications.read', $notification->id) }}" class="btn btn-sm btn-outline-success">
                                      {{ $notification->read_at ? 'View' : 'Mark as Read & View' }}
                                  </a>
                              </div>
                            @empty
                              <p class="dropdown-item">No notifications found</p>
                            @endforelse
                            <a class="dropdown-item" href="{{ route('notifications.index') }}">View All</a>
                          </div>
                        </li>
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown"><i class="align-middle" data-feather="settings"></i></a>
							<a class="nav-link dropdown-toggle d-none d-sm-inline-block flex gap-2 items-center" href="#" data-bs-toggle="dropdown">
									<img src="{{ asset('profile_picture/' . Auth::user()->profile_picture) }}" class="object-cover w-10 h-10 bg-blue-500 rounded-full">
									<span>{{ Auth::user()->username }}</span>
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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fetchNotifications = async () => {
                try {
                    const response = await fetch('/notifications/fetch');

                    const notifList = document.getElementById('notification-list');
                    const badge = document.getElementById('notification-badge');

                    notifList.innerHTML = '';

                    notifications.forEach(notification => {
                        const notifItem = document.createElement('div');
                        notifItem.className = 'dropdown-item d-flex justify-content-between align-items-center bg-light';
                        notifItem.innerHTML = `
                            <div>${notification.message}</div>
                            <a href="/notifications/read/${notification.id}" class="btn btn-sm btn-outline-success">Mark as Read & View</a>
                        `;
                        notifList.appendChild(notifItem);
                    });

                    badge.textContent = notifications.length;
                    badge.classList.toggle('d-none', notifications.length === 0);
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