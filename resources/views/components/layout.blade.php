<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Virtual Library</title>

    @vite('resources/css/app.css')

</head>
<body>
    <header>
        <nav class="navbar navbar-expand navbar-light navbar-bg">
            <div class="navbar-collapse collapse">
                    <a class="sidebar-brand" href="/" style="color:#0a0a0a;">MyLib</a>
                <div class="navbar-nav navbar-align">
                    <a href="{{ route('book.index') }}" class="nav-item navbar-text">
                        Books
                    </a>
                    @if (Route::has('login'))
                        @auth
                            {{-- <a class="nav-item navbar-text"
                                href="{{ route('dashboard') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Dashboard
                            </a> --}}
                            <li class="nav-item dropdown">
                                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                  </a>
    
                                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="" /> <span class="text-dark">{{ $user->name }}</span>
                  </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="align-middle me-1" data-feather="user"></i> Dashboard</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}">Log out</a>
                                </div>
                            </li>
                            {{-- <a class="nav-item navbar-text" 
                                href="{{ route('logout') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Log out
                            </a> --}}
                        @else
                            <a class="nav-item navbar-text"
                                href="{{ route('login') }}"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                            >
                                Log in
                            </a>

                            @if (Route::has('register'))
                                <a class="nav-item navbar-text"
                                    href="{{ route('register') }}"
                                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                >
                                    Register
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>
    </header>

    <main class="container">
        {{ $slot }}
    </main>

    
      <footer>
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <p>Copyright © 2024 <a target="_blank" href="https://www.youtube.com/channel/UCeNYDojo4nU2sbHz1sMsBXw">Web Tech Knowledge
              &nbsp;&nbsp;
              Designed by <a title="HTML CSS Templates" rel="sponsored" href="https://www.youtube.com/channel/UCeNYDojo4nU2sbHz1sMsBXw" target="_blank">Web Tech Knowledge</a></p>
            </div>
          </div>
        </div>
      </footer>
      @vite('resources/js/app.js')
</body>
</html>