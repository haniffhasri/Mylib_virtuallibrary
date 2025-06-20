<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Mylib') }}</title>

    {{-- logo --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png')}}" sizes="96x96" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png')}}" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/lenis@1.3.4/dist/lenis.min.js"></script> 
    <script src="//unpkg.com/alpinejs" defer></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
      @if (Request::is('/')) 
      @else
        <nav id="navbar" class="fixed w-full z-40 bg-white shadow-sm transition-all duration-300 transform -translate-y-full">
          <div class="container mx-auto px-4">
              <div class="flex justify-between items-center h-16">
                  <!-- Logo/Brand -->
                  <div class="flex-shrink-0 flex items-center">
                      <a href="{{ url('/') }}" class="text-xl font-bold transition-colors duration-200">
                          <img class="title-img" src="/logo-removebg-preview.png" alt="" />
                      </a>
                  </div>

                  <!-- Mobile menu button -->
                  <div class="md:hidden flex items-center">
                      <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 pink hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                          <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                          </svg>
                      </button>
                  </div>

                  <!-- Desktop Menu -->
                  <div class="hidden md:flex md:items-center md:space-x-1">
                      <!-- Left Side Links -->
                      <div class="flex space-x-1">
                          <a href="{{ route('book.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Book List</a>
                          <a href="{{ route('forum.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Forum List</a>
                          <a href="{{ route('contact-us.show', ['id' => 1]) }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Contact Us</a>
                          <a href="{{ route('support.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Support</a>
                          
                          @auth
                              @if(Auth::user()?->usertype === 'user')
                              <a href="{{ route('borrow.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">My Books</a>
                              @elseif(Auth::user()?->usertype === 'admin' || Auth::user()?->usertype === 'librarian')
                                  <a href="{{ route('admin.borrow') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Borrow List</a>
                                  <a href="{{ route('book.create') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Add Book</a>
                              @elseif(Auth::user()?->usertype === 'admin')
                                  <a href="{{ route('admin.user') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Users</a>
                                  <a href="{{ route('analytics.index') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Analytics</a>
                              @endif
                          @endauth
                      </div>

                      <!-- Right Side Links -->
                      <div class="ml-4 flex items-center space-x-4">
                          @guest
                              @if (Route::has('login'))
                                  <a href="{{ route('login') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Login</a>
                              @endif

                              @if (Route::has('register'))
                                  <a href="{{ route('register') }}" class="px-3 py-2 rounded-md text-sm font-medium text-white transition-colors duration-200" style="background-color: #ff2f2f;">Register</a>
                              @endif
                          @else
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
                                            @if ($user->profile_picture === 'default.jpg')
                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ asset('profile_picture/default.jpg') }}" alt="Default Profile">
                                            @else
                                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Storage::disk('s3')->url($user->profile_picture) }}" alt="{{ Auth::user()->username }}">
                                            @endif
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
                          @endguest
                      </div>
                  </div>
              </div>
          </div>

          <!-- Mobile menu -->
          <div id="mobile-menu" class="md:hidden hidden">
              <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white shadow-lg">
                  <a href="{{ route('book.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Book List</a>
                  <a href="{{ route('forum.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Forum List</a>
                  <a href="{{ route('contact-us.show', ['id' => 1]) }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Contact Us</a>
                  <a href="{{ route('support.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Support</a>
                  
                  @auth
                      @if(Auth::user()?->usertype === 'user')
                      <a href="{{ route('borrow.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">My Books</a>
                      @elseif(Auth::user()?->usertype === 'admin' || Auth::user()?->usertype === 'librarian')
                          <a href="{{ route('admin.borrow') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Borrow List</a>
                          <a href="{{ route('book.create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Add Book</a>
                      @elseif(Auth::user()?->usertype === 'admin')
                          <a href="{{ route('admin.user') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Users</a>
                          <a href="{{ route('analytics.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Analytics</a>
                      @endif
                  @endauth
                  
                  @guest
                      @if (Route::has('login'))
                          <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Login</a>
                      @endif

                      @if (Route::has('register'))
                          <a href="{{ route('register') }}" class="block px-3 py-2 rounded-md text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-200">Register</a>
                      @endif
                  @else
                      <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Dashboard</a>
                      <a href="{{ route('notifications.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Notifications</a>
                      <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 pink hover:bg-gray-100 transition-colors duration-200">Logout</a>
                      <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                          @csrf
                      </form>
                  @endguest
              </div>
          </div>
      </nav>
      @endif
        <main @if (!Request::is('/')) class="py-4 px-6" style="padding-top: 8rem !important" @endif>
          @yield('content')
      </main>
    </div>

    @stack('scripts')
    <!-- GSAP Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Navbar slide-in animation
            gsap.fromTo("#navbar", 
                { y: -100, opacity: 0 }, 
                { y: 0, opacity: 1, duration: 0.5, ease: "power2.out" }
            );

            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function() {
                if (mobileMenu.classList.contains('hidden')) {
                    // Open menu
                    mobileMenu.classList.remove('hidden');
                    // Reset height to auto before animating
                    gsap.set(mobileMenu, { height: 'auto' });
                    gsap.from(mobileMenu, {
                        height: 0,
                        opacity: 0,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                } else {
                    // Close menu
                    gsap.to(mobileMenu, {
                        height: 0,
                        opacity: 0,
                        duration: 0.3,
                        ease: "power2.in",
                        onComplete: () => {
                            mobileMenu.classList.add('hidden');
                            // Reset inline styles after animation completes
                            gsap.set(mobileMenu, { clearProps: 'height,opacity' });
                        }
                    });
                }
            });

            // Scroll behavior - hide/show navbar on scroll
            let lastScroll = 0;
            window.addEventListener('scroll', function() {
                const currentScroll = window.pageYOffset;
                
                if (currentScroll <= 0) {
                    // At top of page
                    gsap.to("#navbar", { y: 0, duration: 0.3 });
                } else if (currentScroll > lastScroll) {
                    // Scrolling down
                    gsap.to("#navbar", { y: -80, duration: 0.3 });
                } else {
                    // Scrolling up
                    gsap.to("#navbar", { y: 0, duration: 0.3 });
                }
                
                lastScroll = currentScroll;
            });

            // Notification badge animation when count changes
            const notificationBadge = document.querySelector('.notification-badge');
            if (notificationBadge) {
                gsap.from(notificationBadge, {
                    scale: 1.5,
                    duration: 0.5,
                    ease: "elastic.out(1, 0.5)"
                });
            }
        });
    </script>
    <script>
      document.addEventListener('DOMContentLoaded', () => {
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
    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', () => {
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
      });
    </script>
</body>
</html>
