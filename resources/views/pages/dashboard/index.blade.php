@extends('layouts.app')

@section('content')
    <h1 class="container">Appartamenti</h1>

    <div class="mx-3 mt-3">
        <a href="{{ route('dashboard.apartments.create') }}" class="btn btn-primary w-100">
            <i class="bi bi-pencil"></i> Create
        </a>

        <table class="table table-striped">
            <thead>
                <tr>
                    @foreach ($table_headers_values as $table_header)
                        <th>{{ $table_header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($apartments as $apartment)
                    <tr>
                        <td>{{ $apartment->id }}</td>
                        <td> <a href="{{ route('dashboard.apartments.show', $apartment->slug) }}">{{ $apartment->title }}</a>
                        </td>
                        <td>{{ $apartment->slug }}</td>
                        <td>{{ $apartment->description }}</td>
                        <td>
                            {{ $apartment->cover_image }}
                        </td>
                        <td>{{ $apartment->created_at }}</td>
                        <td>{{ $apartment->updated_at }}</td>
                        <td>
                            <a href="{{ route('dashboard.apartments.edit', $apartment->slug) }}" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('dashboard.apartments.destroy', $apartment->slug) }}" method="POST">

                                @csrf

                                @method('DELETE')

                                <input class="btn btn-danger" type="submit" value="Delete">
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
