@extends('layouts.access')

@section('content')
    <section class="text-center text-lg-start">
        <style>
            .cascading-right {
                margin-right: -50px;
            }

            @media (max-width: 991.98px) {
                .cascading-right {
                    margin-right: 0;
                }
            }
        </style>

        <!-- Jumbotron -->
        <div class="container py-4">
            <div class="row g-0 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card cascading-right bg-body-tertiary" style="backdrop-filter: blur(30px);">
                        <div class="card-body p-5 shadow-5 text-center">
                            <h2 class="fw-bold mb-5">{{ __('Registrati ora') }}</h2>
                            <form id="userForm" method="POST" action="{{ route('register') }}">
                                @csrf
                                {{-- 3 column grid layout with text inputs for the first and last names and datof birth --}}
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>
                                            <label for="name"
                                                class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}
                                            </label>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-4">
                                        <div data-mdb-input-init class="form-outline">
                                            <input id="surname" type="text"
                                                class="form-control @error('surname') is-invalid @enderror" name="surname"
                                                value="{{ old('surname') }}" required autocomplete="surname" autofocus>
                                            <label for="surname" class="col-form-label text-md-right">{{ __('Cognome') }}
                                            </label>

                                            @error('surname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- Data di nascita --}}
                                    <div class="form-outline mb-4 col-md-4">
                                        <input id="date_of_birth" type="date"
                                            class="form-control @error('date_of_birth') is-invalid @enderror"
                                            name="date_of_birth" value="{{ old('date_of_birth') }}" required
                                            autocomplete="date_of_birth" autofocus
                                            min="{{ date('Y-m-d', strtotime('-100 years')) }}"
                                            max="{{ date('Y-m-d', strtotime('-18 years')) }}">

                                        @error('date_of_birth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        <label for="date_of_birth"
                                            class="col-form-label text-md-right">{{ __('Data di nascita') }}
                                        </label>
                                    </div>
                                </div>



                                {{-- Email input --}}
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email">
                                    <label for="email" class="col-form-label text-md-right">{{ __('Indirizzo E-Mail') }}
                                    </label>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>


                                {{-- Password input  --}}
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <div class="form-text text-start ">La password deve avere minimo 8 caratteri.</div>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" minlength="8">

                                    <label for="password" class="col-form-label text-md-right">{{ __('Password') }}
                                    </label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Password confirm input --}}

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password" minlength="8">
                                    <label for="password-confirm"
                                        class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }}
                                    </label>
                                </div>
                                <div id="servicesError" class="alert alert-danger mt-1 d-none" role="alert">
                                    Le password non corrispondono.
                                </div>

                                {{-- Submit button --}}
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                    class="btn btn-secondary btn-block mb-4 w-75">
                                    {{ __('Registrati') }}
                                </button>

                                {{-- Login buttons --}}
                                <div class="text-center">
                                    <p>Sei già registrato? Effettua il login.</p>
                                    <div class="">
                                        <a class="btn btn-primary btn-block mb-4"
                                            href="{{ route('login') }}">{{ __('Login') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                    <img src="{{ Vite::asset('resources/assets/img/motoki-tonn-OVK3wg9r4FA-unsplash.jpg') }}"
                        class="w-100 rounded-4 shadow-4" alt="sfondo case" height="850" />
                </div>
            </div>
        </div>
        {{--  Jumbotron  --}}
    </section>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('userForm').addEventListener('submit', function(event) {

                const firstPassword = document.getElementById("password").value;
                const confirmPassword = document.getElementById("password-confirm").value;

                if (firstPassword !== confirmPassword) {
                    event.preventDefault();
                    document.getElementById('servicesError').classList.remove('d-none');
                } else {
                    document.getElementById('servicesError').classList.add('d-none');
                }
            });
        });
    </script>
@endsection
