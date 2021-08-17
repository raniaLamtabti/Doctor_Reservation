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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar dash navbar-expand-md bg-white shadow-sm">
            <div class="dashboardN content">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    Go<span>Doctor</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <img src="{{ asset('images/menu.svg') }}" alt="" srcset="">
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav nav-left">
                        @if(Auth::guard('web')->check())
                        <li class="button">
                            <a href="{{ url('/index' )}}">Make Appointment</a>
                        </li>
                        @elseif(Auth::guard('admin')->check())
                        <li class="button">
                            <a href="{{ route('admin.blog') }}">Articles</a>
                        </li>
                        @endif
                        <li class="today">
                            <div class="icon">
                                <img src="{{ asset('images/Icon feather-calendar3.png') }}" alt="">
                            </div>
                            <div class="content">
                                <h3>Today</h3>
                                <span>{{ now()->toDateString() }}</span>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle name" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                @auth('doctor')
                                    <img src="{{ asset(Auth::User()->image) }}" alt="" height="50px" width="50px" style="border-radius: 10px">
                                @endauth
                                <div class="content">
                                    {{ Auth::user()->name }}
                                    {{-- @auth('doctor')
                                    <span>{{ App\Models\Specialty::find(Auth::user()->specialty_id)->name }}</span>
                                    @endauth --}}
                                </div>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(Auth::guard('web')->check())
                                <a href="{{ route('user.editUser', ['id' => Auth::guard('web')->user()->id]) }}">Profile</a>
                                @elseif(Auth::guard('doctor')->check())
                                <a href="{{ route('doctor.editDoctor', ['id' => Auth::guard('doctor')->user()->id]) }}">Profile</a>
                                @elseif(Auth::guard('admin')->check())
                                <a href="{{ route('admin.editAdmin', ['id' => Auth::guard('admin')->user()->id])  }}">Profile</a>
                                @endif
                                <br>
                                @if(Auth::guard('doctor')->check())
                                <a href="{{ route('doctor.uptime') }}">Work Hours</a>
                                @endif
                                <hr>
                                @if(Auth::guard('web')->check())
                                <a class="dropdown-item" href="{{ route('user.logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('user.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                @elseif(Auth::guard('doctor')->check())
                                <a class="dropdown-item" href="{{ route('doctor.logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('doctor.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>

                                @elseif(Auth::guard('admin')->check())
                                <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                                @endif
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <footer style="position: fixed;bottom:0;width:100%">
            <div class="copyright">
                <p>Copyright © 2021 RaniaLm. All Rights Reserved</p>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
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

        $('#example').DataTable();
        $('#example2').DataTable();
    </script>
    @yield('scripts')
</body>
</html>
