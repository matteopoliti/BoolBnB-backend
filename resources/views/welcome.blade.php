@extends('layouts.access')
@section('content')
    <div class="px-4 pt-5 text-center border-bottom bg-light" style="height: calc(100vh - 80px)">
        <h1 class="display-4 fw-bold text-body-emphasis">Benvenuto nell'area personale di Boolbnb</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Carica le informazioni della tua proprietà, imposta il prezzo e connettiti con
                acquirenti interessati. Gestisci tutto comodamente dalla tua dashboard. Inizia oggi stesso!</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mb-5">
                @guest

                    <div class="">
                        <a class="btn btn-primary btn-lg px-4 me-sm-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </div>
                    @if (Route::has('register'))
                        <div class="">
                            <a class="btn btn-outline-secondary btn-lg px-4"
                                href="{{ route('register') }}">{{ __('Registrati') }}</a>
                        </div>
                    @endif
                @else
                    <li class="nav-item dropstart">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                                href="{{ route('dashboard.apartments.index') }}">{{ __('Apartamenti') }}</a>
                            <a class="dropdown-item" href="{{ url('profile') }}">{{ __('Profilo') }}</a>
                        </div>
                    </li>
                @endguest
            </div>
        </div>
        <div>
            <div class="container px-5">
                <img src="{{ Vite::asset('resources/assets/img/Screenshot 2024-05-05 153637.png') }}"
                    class="img-fluid border rounded-3 shadow-lg mb-4" alt="Example image" width="700" height="500"
                    loading="lazy">
            </div>
        </div>
    </div>
@endsection
