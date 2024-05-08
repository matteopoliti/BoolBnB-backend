@extends('layouts.access')

@section('content')
    <section style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">

                                    <div class="text-center">
                                        <img src="{{ Vite::asset('resources/assets/img/logo-boolbnb-nome.png') }}"
                                            style="width: 185px;" alt="logo">
                                        <h4 class="mt-1 mb-5 pb-1">Area personale</h4>
                                    </div>

                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <p><strong>Effettua l'accesso al tuo account</strong></p>

                                        <div class="form-outline mb-4">
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>
                                            <label for="email"
                                                class="col-form-label text-md-right">{{ __('Indirizzo E-Mail') }}
                                            </label>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-outline mb-4">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password" minlength="8">
                                            <label for="password"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Password') }}
                                            </label>

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mb-4 row">
                                            <div class="col-md-6 offset-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="remember"
                                                        id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="remember">
                                                        {{ __('Ricordami') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-center pt-1 mb-5 pb-1">
                                            <button
                                                class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3 border-0 w-100"
                                                type="submit">{{ __('Login') }}
                                            </button><br>
                                            @if (Route::has('password.request'))
                                                <a class="text-muted text-decoration-none "
                                                    href="{{ route('password.request') }}">
                                                    {{ __('Dimenticata la Password?') }}
                                                </a>
                                            @endif
                                        </div>

                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Non hai un account?</p>
                                            <a class="btn btn-outline-secondary"
                                                href="{{ route('register') }}">{{ __('Registrati') }}</a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2 rounded-end">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    <h3 class="mb-4 fs-2">Benvenuto su BoolBnB: Gestisci le Tue Proprietà!</h3>
                                    <p class="mb-0">Sei pronto a far brillare le tue case? Accedi come host su
                                        BoolBnb
                                        e inizia a gestire le tue proprietà come mai prima d'ora. Inserisci le tue
                                        credenziali qui a sinistra per dare vita al tuo portafoglio immobiliare.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
