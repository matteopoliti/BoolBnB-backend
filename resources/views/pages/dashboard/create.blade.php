@extends('layouts.app')

@section('content')
    <div class="mx-3 mt-3">

        <div class="container">
            <h1 class="mt-2 fw-bold">Aggiungi un nuovo appartamento:</h1>

            <form action="{{ route('dashboard.apartments.store') }}" id="apartmentForm" method="POST"
                enctype="multipart/form-data" class="mb-5">

                @csrf

                <div class="my-3 col-12">
                    <label for="title" class="form-label">Titolo*</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        aria-describedby="title" name="title" value='{{ old('title') }}' maxlength="100" required>
                    @error('title')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3 col-12">
                    <label for="description" class="form-label">Descrizione</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3 col-12">
                    <label for="category" class="form-label">Categoria*</label>
                    <select
                        class="form-select form-select-lg
                        @error('category')
                            is_invalid
                        @enderror"
                        name="category" id="category" required>
                        <option value="" selected>Seleziona</option>

                        @foreach ($categories_apartment as $item)
                            <option value="{{ $item }}" {{ $item == old('category') ? 'selected' : '' }}>
                                {{ ucfirst($item) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row my-3">
                    <div class=" col-3 col-6 col-lg-3">
                        <label for="price" class="form-label">Prezzo/Notte*</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">€</span>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                aria-describedby="price" name="price" value='{{ old('price') }}' required min="0">
                            <span class="input-group-text">.00</span>
                        </div>
                        @error('price')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-3 col-6 col-lg-3">
                        <label for="num_rooms" class="form-label">Stanze*</label>
                        <input type="number" class="form-control @error('num_rooms') is-invalid @enderror" id="num_rooms"
                            aria-describedby="num_rooms" name="num_rooms" value='{{ old('num_rooms') }}' min="0"
                            required>
                        @error('num_rooms')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-3 col-6 col-lg-3">
                        <label for="num_beds" class="form-label">Letti*</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-bed"></i></span>
                            <input type="number" class="form-control @error('num_beds') is-invalid @enderror"
                                id="num_beds" aria-describedby="num_beds" name="num_beds" value='{{ old('num_beds') }}'
                                min="0" required>
                        </div>
                        @error('num_beds')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-3 col-6 col-lg-3">
                        <label for="num_bathrooms" class="form-label">Bagni*</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-bath"></i></i></span>
                            <input type="number" class="form-control @error('num_bathrooms') is-invalid @enderror"
                                id="num_bathrooms" aria-describedby="num_bathrooms" name="num_bathrooms"
                                value='{{ old('num_bathrooms') }}' min="0" required>
                        </div>
                        @error('num_bathrooms')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row my-3">
                    <div class="col-12 col-lg-6">
                        <label for="full_address" class="form-label">Indirizzo completo*</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                            <input list="addressList" type="text"
                                class="form-control @error('full_address') is-invalid @enderror" id="full_address"
                                aria-describedby="full_address" name="full_address" value='{{ old('full_address') }}'
                                maxlength="255" required>
                            <datalist id="addressList">
                            </datalist>
                        </div>
                        @error('full_address')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 col-lg-6 mt-3 mt-lg-0">
                        <label for="square_meters" class="form-label">Metri quadri*</label>
                        <div class="input-group mb-3">
                            <input type="number" step="0.01" min="0"
                                class="form-control @error('square_meters') is-invalid @enderror" id="square_meters"
                                aria-describedby="square_meters" name="square_meters" value='{{ old('square_meters') }}'
                                required>
                            <span class="input-group-text">m<sup>2</sup></span>
                        </div>
                        @error('square_meters')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-12 mb-3">
                    <label for="cover_image" class="form-label">Immagine di copertina*</label>
                    <input type="file" name="cover_image" id="cover_image"
                        class="form-control
                        @error('cover_image') is-invalid @enderror" required>
                    @error('cover_image')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- <div class="mb-3">
                    <label for="more_images[]" class="form-label">Immagine aggiuntive</label>
                    <input type="file" name="more_images[]" id="more_images[]"
                        class="form-control
                        @error('more_images[]') is-invalid @enderror">
                    @error('more_images[]')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div> --}}

                <div class="row mt-4" id="moreImagesContainer">
                    <label for="cover_image" class="form-label">Immagine aggiuntive</label>
                    
                    <div class="col-12 col-sm-10 col-lg-6 col-xxl-4 mb-4 text-center mx-auto" id="image-container-1">
                        <div class="position-relative">
                            <div class="rounded overflow-hidden">
                                <img id="selectedImage" src="{{ Vite::asset('resources/assets/img/add-img.jpg') }}"
                                    alt="example placeholder" class="img-fluid object-fit-cover"
                                    style="max-width: fit-content; max-height:300px;" />
                            </div>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <div data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-rounded">
                                    <label class="form-label text-white m-1" for="customFile1">+</label>
                                    <input type="file" name="images[]" class="form-control d-none" id="customFile1"
                                        onchange="displaySelectedImage(event, 'selectedImage')" />
                                </div>
                                @error('images[]')
                                    <div class="alert alert-danger mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="btn btn-outline-danger position-absolute top-0 end-0 d-none"
                                onclick="removeElement('image-container-1')">
                                <i class="fas fa-x"></i>
                            </div>
                        </div>
                        <div class="mt-2 mb-3 col-12">
                            <label for="categories[]" class="form-label">Categoria</label>
                            <select
                                class="form-select form-select-lg
                                @error('categories[]')
                                    is_invalid
                                @enderror"
                                name="categories[]" id="categories[]" disabled>
                                <option value="" selected>Seleziona</option>

                                @foreach ($categories_images as $item)
                                    <option value="{{ $item }}"
                                        {{ $item == old('categories[]') ? 'selected' : '' }}>
                                        {{ ucfirst($item) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Servizi*</label>
                    <div class="form-check">
                        @foreach ($services as $item)
                            <img src="{{ asset('/storage/' . $item->icon) }}" alt="{{ $item->name }}"
                                style="width: 15px">
                            <input class="form-check-input" type="checkbox" name="services[]"
                                id="service_{{ $item->id }}" value="{{ $item->id }}"
                                {{ is_array(old('services')) && in_array($item->id, old('services')) ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="service_{{ $item->id }}">{{ ucfirst($item->name) }}</label><br>
                        @endforeach
                    </div>
                    @error('services')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="servicesError" class="alert alert-danger mt-1 d-none" role="alert">
                        Seleziona almeno un servizio.
                    </div>
                </div>

                <button type="submit" class="btn gradient-custom-2 border-0 text-light mx-auto d-block">Aggiungi</button>

                <div class="alert alert-secondary mt-3" role="alert">
                    Ricorda di compilare tutti i campi con *
                </div>
            </form>
        </div>
    </div>

    <script>
        let imageCounter = 2;

        function removeElement(elementId) {
            var elementToRemove = document.getElementById(elementId);
            if (!elementToRemove) return; // Exit if the element does not exist

            var fileInput = elementToRemove.querySelector('input[type="file"]');
            var selectElement = elementToRemove.querySelector('select');

            elementToRemove.parentNode.removeChild(elementToRemove);
        }

        document.addEventListener('DOMContentLoaded', function() {

            document.getElementById('apartmentForm').addEventListener('change', function(event) {
                if (event.target.name === 'images[]') {
                    const input = event.target;
                    const hasImage = input.files.length > 0;
                    const parentDiv = input.closest('.col-12');

                    const categorySelect = parentDiv.querySelector('select[name="categories[]"]');

                    // Utilizzare l'ID univoco per selezionare il bottone
                    var deleteButton = parentDiv.querySelector('.btn-outline-danger');

                    if (hasImage) {
                        categorySelect.removeAttribute('disabled');
                        categorySelect.setAttribute('required', 'required');
                        deleteButton.classList.remove('d-none')
                    } else {
                        categorySelect.removeAttribute('required');
                        categorySelect.setAttribute('disabled', 'disabled');
                    }
                }
            });

            document.getElementById('apartmentForm').addEventListener('submit', function(event) {
                const checkboxes = document.querySelectorAll('input[name="services[]"]');
                let checked = false;
                checkboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        checked = true;
                    }
                });
                if (!checked) {
                    event.preventDefault();
                    document.getElementById('servicesError').classList.remove('d-none');
                } else {
                    document.getElementById('servicesError').classList.add('d-none');
                }
            });

            window.displaySelectedImage = function(event, elementId) {
                const selectedImage = document.getElementById(elementId);
                const fileInput = event.target;

                const uniqueId = 'image-input-' + imageCounter; // ID univoco per il contenitore


                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        selectedImage.src = e.target.result;
                    };

                    reader.readAsDataURL(fileInput.files[0]);
                }

                if (selectedImage.src.startsWith('data:')) {
                    console.log(selectedImage)
                    return
                } else {
                    // Altrimenti, crea un nuovo elemento solo se non esiste già
                    const parentElement = document.getElementById('moreImagesContainer');
                    const childElement = document.createElement('div');
                    childElement.classList.add('col-12', 'mb-4', 'col-sm-10', 'col-lg-6', 'col-xxl-4', 'text-center', 'mx-auto');
                    childElement.setAttribute('id', uniqueId);

                    // Utilizza la variabile globale per generare ID univoci
                    const currentImageCounter = imageCounter;

                    console.log('immagine caricata')

                    childElement.innerHTML = `
                        <div class="position-relative">
                            <div class="rounded overflow-hidden">
                                <img id="selectedImage${currentImageCounter}" src="{{ Vite::asset('resources/assets/img/add-img.jpg') }}"
                                    alt="example placeholder" class="img-fluid object-fit-cover" style="max-width:fit-content; max-height: 300px"/>
                            </div>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <div data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-rounded">
                                    <label class="form-label text-white m-1" for="customFile${currentImageCounter}">+</label>
                                    <input type="file" name="images[]" class="form-control d-none" id="customFile${currentImageCounter}" onchange="displaySelectedImage(event, 'selectedImage${currentImageCounter}')" />
                                </div>
                            </div>
                            <div class="btn btn-outline-danger position-absolute top-0 end-0 d-none" onclick="removeElement('${uniqueId}')">
                                <i class="fas fa-x"></i>
                            </div>
                        </div>
                        <div class="mt-2 mb-3 col-12 mx-auto">
                            <label for="categories[]" class="form-label">Categoria</label>
                            <select
                                class="form-select form-select-lg
                                @error('categories[]')
                                    is_invalid
                                @enderror"
                                name="categories[]" id="categories[]" disabled>
                                <option value="" selected>Seleziona</option>

                                @foreach ($categories_images as $item)
                                    <option value="{{ $item }}" {{ $item == old('categories[]') ? 'selected' : '' }}>
                                        {{ ucfirst($item) }}</option>
                                @endforeach
                            </select>
                        </div>`;

                    parentElement.appendChild(childElement);

                    // Incrementa la variabile globale per il prossimo ID
                    imageCounter++;
                }
            };
        });

        document.getElementById('full_address').addEventListener('input', function(event) {

            const apiKey = "{{ $apiKey }}";

            const apiQuery = document.getElementById('full_address');

            let apiRequest =
                `https://api.tomtom.com/search/2/search/${apiQuery.value}.json?key=${apiKey}&language=it-IT&countrySet=IT`;

            const parentElement = document.getElementById('addressList');

            if (apiQuery.value === '') {

                while (parentElement.firstChild) {
                    parentElement.removeChild(parentElement.firstChild);
                }

                return
            }

            fetch(apiRequest)
                .then(response => {

                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }

                    return response.json();
                })
                .then(data => {

                    let apiResults = data.results

                    let arrayResults = []

                    apiResults.forEach(element => {
                        arrayResults.push(element.address.freeformAddress)
                    });

                    console.log(arrayResults)

                    while (parentElement.firstChild) {
                        parentElement.removeChild(parentElement.firstChild);
                    }

                    arrayResults.forEach(element => {
                        const childElement = document.createElement('option');
                        parentElement.append(childElement);
                        childElement.value = element;
                    });
                })
                .catch(error => {

                    console.error('There was a problem with the fetch operation:', error);
                });
        });
    </script>

    <style>
        #moreImagesContainer>div .btn {
            display: none
        }

        #moreImagesContainer>div:hover .btn {
            display: block
        }
    </style>
@endsection
