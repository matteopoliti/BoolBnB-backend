@extends('layouts.access')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
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
    </div>
@endsection
