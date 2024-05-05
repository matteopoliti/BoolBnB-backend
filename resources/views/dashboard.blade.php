@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header gradient-custom-2 text-white">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <h5 class="card-title">Ciao {{ ucfirst(Auth::user()->name) }}</h5>

                        <p class="card-text">{{ __("Hai effettuato l'accesso con successo!") }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
