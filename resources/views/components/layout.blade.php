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
                    <a class="sidebar-brand" href="/">MyLib</a>
                <div class="navbar-nav navbar-align">
                    <a href="{{ route('book.index') }}" class="nav-item navbar-text" style="color: white;">
                        Books
                    </a>
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                  </a>
    
                                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <img src="img/avatars/avatar.jpg" class="avatar img-fluid rounded me-1" alt="" /> <span style="color:white;">{{ $user->name }}</span>
                  </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('dashboard') }}"><i class="align-middle me-1" data-feather="user"></i> Dashboard</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}">Log out</a>
                                </div>
                            </li>
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

    <main class="main">
        {{ $slot }}
    </main>

    
    <footer class="footer">
        <div class="footer-container">
          <div class="footer-col">
            <img src="./img/logo-example-1.png" alt="logo">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque nostrum porro rem est ab ad accusantium eveniet exercitationem corporis voluptas, dolores amet maxime facilis maiores! Ea corrupti rerum sunt velit.</p>
          </div>
          <div class="footer-col">
            <h4>Contact options</h4>
            <p><a href="mailto:email@example.com?subject=Enquiry&body=Hello, I have a question">Email me</a></p>
            <p>Call me: <a href="tel:+1234567890">+1 (234) 567-8900</a></p>
            <p><a href="https://wa.me/1234567890?text=Hello,%20I%20have%20a%20question">Contact me on WhatsApp</a></p>
          </div>
          <div class="footer-col">
            <h4>Sitemap</h4>
            <nav>
              <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="contact.html">Contact</a></li>
              </ul>
            </nav>
          </div>
        </div>
        <div class="bottombar">Copyright © 2023 Your_Name. All rights reserved.</div>
      </footer>
      @vite('resources/js/app.js')
</body>
</html>