@extends('layouts.app')

@section('content')
    <div class="mx-3 mt-3">

        <div class="container">
            <h1 class="mt-2 fw-bold">Create a new apartment:</h1>

            <form action="{{ route('dashboard.apartments.update', $apartment->slug) }}" method="POST"
                enctype="multipart/form-data" class="mb-5">

                @csrf

                @method('PUT')

                <div class="my-3">
                    <label for="title" class="form-label">Insert the title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        aria-describedby="title" name="title" value='{{ old('title') ?? $apartment->title }}'
                        maxlength="100" required>
                    @error('title')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Insert the description</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ old('description') ?? $apartment->description }}</textarea>
                    @error('title')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="category" class="form-label">Categories</label>
                    <select
                        class="form-select form-select-lg
                        @error('category')
                            is_invalid
                        @enderror"
                        name="category" id="category" required>
                        <option selected>Select one</option>

                        @foreach ($categories as $item)
                            <option value="{{ $item }}"
                                {{ $item == old('category', $apartment->category) ? 'selected' : '' }}>
                                {{ ucfirst($item) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row my-3">

                    <div class=" col-3 ">
                        <label for="price" class="form-label">Price/night:</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                            aria-describedby="price" name="price" value='{{ old('price') ?? $apartment->price }}'
                            required>
                        @error('price')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-3 ">
                        <label for="num_rooms" class="form-label">Rooms:</label>
                        <input type="number" class="form-control @error('num_rooms') is-invalid @enderror" id="num_rooms"
                            aria-describedby="num_rooms" name="num_rooms"
                            value='{{ old('num_rooms') ?? $apartment->num_rooms }}' min="1" max="50" required>
                        @error('num_rooms')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-3 ">
                        <label for="num_beds" class="form-label">Beds:</label>
                        <input type="number" class="form-control @error('num_beds') is-invalid @enderror" id="num_beds"
                            aria-describedby="num_beds" name="num_beds"
                            value='{{ old('num_beds') ?? $apartment->num_beds }}' min="1" max="50" required>
                        @error('num_beds')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-3 ">
                        <label for="num_bathrooms" class="form-label">Bathrooms:</label>
                        <input type="number" class="form-control @error('num_bathrooms') is-invalid @enderror"
                            id="num_bathrooms" aria-describedby="num_bathrooms" name="num_bathrooms"
                            value='{{ old('num_bathrooms') ?? $apartment->num_bathrooms }}' min="1" max="50"
                            required>
                        @error('num_bathrooms')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row my-3">

                    <div class=" col-6">
                        <label for="full_address" class="form-label">Insert the street, number, postal code and city</label>
                        <input type="text" class="form-control @error('full_address') is-invalid @enderror"
                            id="full_address" aria-describedby="full_address" name="full_address"
                            value='{{ old('full_address') ?? $apartment->full_address }}' maxlength="255" required>
                        @error('full_address')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="square_meters" class="form-label">Square meters:</label>
                        <input type="number" step="0.01" min="30.00" max="999.99"
                            class="form-control @error('square_meters') is-invalid @enderror" id="square_meters"
                            aria-describedby="square_meters" name="square_meters"
                            value='{{ old('square_meters') ?? $apartment->square_meters }}' required>
                        @error('square_meters')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>


                </div>

                {{-- <div class="mb-3">
                    <label for="tags" class="form-label">Tags</label>
                    <select multiple
                        class="form-select form-select-lg
                        @error('tags')
                            is_invalid
                        @enderror"
                        name="tags[]" id="tags">
                        @forelse($tags as $item)
                            <option value="{{ $item->id }}" {{ $item->id == old('tags') ? 'selected' : '' }}>
                                {{ $item->name }}</option>
                        @empty
                            <option value="">Non ci sono tags</option>
                        @endforelse
                    </select>
                </div> --}}

                <div class="mb-3">
                    @if ($apartment->cover_image)
                        <figure class="mb-3">
                            <img src="{{ asset('/storage/' . $apartment->cover_image) }}" alt="{{ $apartment->slug }}">
                        </figure>
                    @endif
                    <input type="file" name="cover_image" id="cover_image"
                        class="form-control
                        @error('cover_image') is-invalid @enderror">
                    @error('cover_image')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <button type="submit" class="btn btn-primary">ADD</button>
            </form>
            <a href="{{ route('dashboard.apartments.index') }}" class="btn btn-primary w-100">
                Torna a tutti gli appartamenti
            </a>
        </div>
    </div>
@endsection
