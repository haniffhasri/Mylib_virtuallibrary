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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
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
                            @if(Auth::user()?->usertype === 'user')
                            <a class="nav-link" href="{{ route('borrow.index') }}">My Borrowed Books</a>
                            @elseif(Auth::user()?->usertype === 'admin' || Auth::user()?->usertype === 'librarian')
                                <a class="nav-link" href="{{ route('admin.borrow') }}">Borrow List</a>
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
                        <li class="nav-item dropdown flex items-center">
                          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Notifications
                            @if($headerNotifications->count() > 0)
                              <span class="badge bg-danger">{{ $headerNotifications->count() }}</span>
                            @endif
                          </a>

                          <div class="dropdown-menu w-max notification-dropdown dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @forelse($headerNotifications as $notification)
                                <div class="dropdown-item d-flex justify-content-between align-items-center {{ $notification->read_at ? '' : 'bg-light' }}">
                                    <div>
                                        {{ $notification->data['message'] }}
                                    </div>
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
      $('.testimonial-slider').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 1,
              infinite: true,
            },
          },
          {
            breakpoint: 800,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              infinite: true,
            },
          },
          {
            breakpoint: 565,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
            },
          },
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ],
      });

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

    <script>
      gsap.registerPlugin(ScrollTrigger);

      if ($(window).width() > 768) {
        gsap
          .timeline({
            scrollTrigger: {
              trigger: '.did-you-know-col',
              pin: '.did-you-know-col',
              start: 'top top',
              end: 'bottom top',
              scrub: true,
              toggleActions: 'play reverse play reverse',
              ease: 'none',
            },
          })
          .to('.dyk-col-1', { opacity: 1 })
          .to('.dyk-col-3', { opacity: 1 })
          .to('.dyk-col-4', { opacity: 1 });
      } else {
        gsap
          .timeline({
            scrollTrigger: {
              trigger: '.did-you-know-col',
              // pin: ".did-you-know-col",
              start: 'top 40%',
              end: 'center top',
              scrub: true,
              toggleActions: 'play reverse play reverse',
              ease: 'none',
            },
          })
          .to('.dyk-col-1', { opacity: 1 })
          .to('.dyk-col-3', { opacity: 1 })
          .to('.dyk-col-4', { opacity: 1 });
      }

      if ($(window).width() < 565) {
        gsap
          .timeline({
            scrollTrigger: {
              trigger: '.gh-section eighth',
              start: 'bottom bottom',
              toggleActions: 'play reverse play reverse',
              scrub: true,
              ease: 'linear',
            },
          })
          .to('.floating-widget', {
            opacity: 0,
            pointerEvents: 'none',
          });
      }
    </script>
</body>
</html>
