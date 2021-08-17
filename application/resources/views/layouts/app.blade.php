<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('owlcarousel/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('owlcarousel/owl.theme.default.min.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md bg-white shadow-sm">
            <div class="container app content">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Go<span>Doctor</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <img src="{{ asset('images/menu.svg') }}" alt="" srcset="">
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav nav-left mr-auto">
                        <li><a href="{{ url('/home' )}}" class="{{ Request::segment(1) === 'home' ? 'active' : null }}">Home</a></li>
                        <li><a href="{{ url('/index' )}}" class="{{ Request::segment(1) === 'index' || Request::segment(1) === 'find' ? 'active' : null }}">FindDr</a></li>
                        <li><a href="" class="{{ Request::segment(1) === 'about' ? 'active' : null }}">About Us</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav nav-right ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link login" href="{{ route('user.login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link register" href="{{ route('user.register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle name" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('user.editUser', ['id' => Auth::guard('web')->user()->id]) }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>Profile</a>
                                    <hr>
                                    <a class="dropdown-item" href="{{ route('user.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <footer>
            <div class="container links d-flex flex-wrap">
                <div class="subscribe">
                    <img src="{{ asset('images/footer.png') }}" alt="">
                    <h1>Subscribe to our newsletter</h1>
                    <form action="">
                        <input type="text" placeholder="Email">
                        <button>SUBSCRIBE</button>
                    </form>
                </div>
                <div class="information">
                    <h1>Information</h1>
                    <ul>
                        <li><a href="">About Us</a></li>
                        <li><a href="">Privacy Policy</a></li>
                        <li><a href="">Contact Us</a></li>
                        <li><a href="">Support</a></li>
                        <li><a href="">Terms and conditions</a></li>
                        <li><a href="">Team</a></li>
                    </ul>
                </div>
                <div class="right">
                    <div class="blog">
                        <h1>Blog</h1>
                        <ul>
                            <li><a href="">Article number 1</a></li>
                            <li><a href="">Article number 2</a></li>
                            <li><a href="">Article number 3</a></li>
                        </ul>
                    </div>
                    <div class="follow">
                        <h1>follow us</h1>
                        <ul>
                            <li><img src="{{ asset('images/Icon feather-facebook.png') }}" alt=""></li>
                            <li><img src="{{ asset('images/Icon awesome-instagram.png') }}" alt=""></li>
                            <li><img src="{{ asset('images/Icon feather-twitter.png') }}" alt=""></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>Copyright © 2021 RaniaLm. All Rights Reserved</p>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('owlcarousel/owl.carousel.js') }}"></script>
    <script>
        $('.owl-carousel').owlCarousel({
            margin:10,
            responsive:{
                0:{
                    items:1
                },
                900:{
                    items:2
                },
                1200:{
                    items:3
                }
            }
        })
    </script>
    @yield('scripts')
</body>
</html>
