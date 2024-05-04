<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BoolBnB</title>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- link Fontawesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Favicon --}}
    <link rel="icon" href="{{ Vite::asset('resources/assets/img/logo-boolbnb.png') }}">

    {{-- Script braintree --}}
    <script src="https://js.braintreegateway.com/web/dropin/1.42.0/js/dropin.js"></script>

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<body>
    <div id="app">

        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('http://localhost:5174/') }}">
                    <div class="logo_laravel">
                        <img src="{{ Vite::asset('resources/assets/img/logo-boolbnb-nome-tiny.png') }}" alt=""
                            class="w-50">
                    </div>
                    {{-- config('app.name', 'Laravel') --}}
                </a>

                <h2 class="mb-0">Dashboard</h2>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropstart">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ ucfirst(Auth::user()->name) }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                              {{--  <a class="dropdown-item"
                                     href="{{ route('dashboard.apartments.index') }}">{{ __('Apartamenti') }}</a> --}}
                                    <a class="dropdown-item " href="{{ url('profile') }}"><i class="fa-solid fa-gear"></i> {{ __('Profilo') }}</a>
                            </div>
                        </li>
                    @endguest
                </ul>

                {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button> --}}

                {{-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">{{ __('Home') }}</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link"
                                href="{{ route('dashboard.apartments.index') }}">{{ __('My Apartment') }}</a>
                        </li>
                    </ul>



                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('dashboard') }}">{{ __('Dashboard') }}</a>
                                    <a class="dropdown-item" href="{{ url('profile') }}">{{ __('Profile') }}</a>
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
                </div> --}}
            </div>
        </nav>



        <div class="dashboard">
            <div class="d-flex flex-column align-items-center flex-shrink-0 bg-body-tertiary side-bar py-4" >

                <ul class="nav nav-pills flex-column gap-4 w-100 mb-auto justify-content-center">
                    <li class="{{ request()->routeIs('dashboard.apartments.index') ? 'active-t4' : '' }} ps-2">
                        <a href="{{ route('dashboard.apartments.index') }}" class="nav-link link-body-emphasis ">
                            <i class="fa-solid fa-house"></i>
                            <span class="fs-5">{{ __('Appartamenti') }}</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.apartments.index') ? 'active-t4' : '' }} ps-2">
                        <a href="#" class="nav-link link-body-emphasis">
                            <i class="fa-solid fa-chart-simple"></i>
                            <span class="fs-5">Statistiche</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.messages') ? 'active-t4' : '' }} ps-2">
                        <a href="{{ route('dashboard.messages') }}" class="nav-link link-body-emphasis">
                            <i class="fa-solid fa-message"></i>
                            <span class="fs-5">Messaggi</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.sponsors') ? 'active-t4' : '' }} ps-2">
                        <a href="{{ route('dashboard.sponsors') }}" class="nav-link link-body-emphasis">
                            <i class="fa-solid fa-credit-card"></i>
                            <span class="fs-5">Sponsor</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('dashboard.apartments.index') ? 'active-t4' : '' }} ps-2">
                        <a href="#" class="nav-link link-body-emphasis">
                            <i class="fa-solid fa-trash"></i>
                            <span class="fs-5">Cestino</span>
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item btn btn-outline-danger " aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                                        <i class="fa-solid fa-right-from-bracket log-out"></i>
                                                        <span>
                                                         {{ __('Logout') }}
                                                        </span>

                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
            <main class=" overflow-auto ">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>
