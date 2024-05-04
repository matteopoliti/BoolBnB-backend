@extends('layouts.access')

@section('content')
    <div class="container">
        {{-- <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Page Not Found</div>

                    <div class="card-body">
                        The page you are looking for could not be found.
                    </div>

                    <a href="http://127.0.0.1:8000/dashboard" class="btn gradient-custom-2">Torna alla homepage</a>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="container d-flex flex-column align-items-center justify-content-center mt-5" style="min-height: 80vh; width: 100%;">
        <div class="row">
          <div class="mt-3">
              <div class="d-flex flex-column justify-content-center">
                <div class="d-flex justify-content-center gap-2">
                  <h2 class="text-center fw-bold m-0 p-0">Errore</h2>
                  <img src="{{ Vite::asset('resources/assets/img/404-Icon.png') }}" style="max-height: 30px; width: 30px;"></img> 
                </div>
                <h1 class="text-center fw-bold m-0 p-0" style="font-size: 80px;">404</h1>
              </div>
              <h5 class="text-center mt-0">Pagina non trovata</h5>
          </div>
        </div>
        <a class="navbar-brand m-0 d-flex flex-column col-2 text-center align-items-center mt-5" href="{{ url('http://127.0.0.1:8000/dashboard') }}">
          <img src="{{ Vite::asset('resources/assets/img/logo-boolbnb.png') }}" alt="Logo" style="width: 40px;" />
          <span class="fs-6 text-center text-decoration-underline" style="scale: 0.8;">Torna alla tua area personale</span>
        </a>
    </div>

@endsection
