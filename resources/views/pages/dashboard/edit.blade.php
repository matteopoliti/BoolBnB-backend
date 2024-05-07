@extends('layouts.app')

@section('content')
    <div class="mx-3 mt-3">

        <div class="container">
            <h1 class="mt-2 fw-bold">Modifica l'appartamento:</h1>

            <form id="apartmentForm" action="{{ route('dashboard.apartments.update', $apartment->slug) }}" method="POST"
                enctype="multipart/form-data" class="mb-5">

                @csrf

                @method('PUT')

                <div class="my-3">
                    <label for="title" class="form-label">Titolo*</label>
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
                    <label for="description" class="form-label">Descrizione</label>
                    <textarea name="description" id="description" cols="30" rows="10" class="form-control">{{ old('description') ?? $apartment->description }}</textarea>
                    @error('description')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <label for="category" class="form-label">Categoria*</label>
                    <select
                        class="form-select form-select-lg
                        @error('category')
                            is_invalid
                        @enderror"
                        name="category" id="category" required>
                        <option value="" selected>Seleziona</option>

                        @foreach ($categories_apartment as $item)
                            <option value="{{ $item }}"
                                {{ $item == old('category', $apartment->category) ? 'selected' : '' }}>
                                {{ ucfirst($item) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row my-3">

                    <div class=" col-3 ">
                        <label for="price" class="form-label">Prezzo/Notte*</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">€</span>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                aria-describedby="price" name="price" value='{{ old('price') ?? $apartment->price }}'
                                required min="0">
                            <span class="input-group-text">.00</span>
                        </div>
                        @error('price')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="col-3 ">
                        <label for="num_rooms" class="form-label">Stanze*</label>
                        <input type="number" class="form-control @error('num_rooms') is-invalid @enderror" id="num_rooms"
                            aria-describedby="num_rooms" name="num_rooms"
                            value='{{ old('num_rooms') ?? $apartment->num_rooms }}' min="0" required>
                        @error('num_rooms')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-3 ">
                        <label for="num_beds" class="form-label">Letti*</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-bed"></i></span>
                            <input type="number" class="form-control @error('num_beds') is-invalid @enderror"
                                id="num_beds" aria-describedby="num_beds" name="num_beds"
                                value='{{ old('num_beds') ?? $apartment->num_beds }}' min="0" required>
                        </div>
                        @error('num_beds')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-3 ">
                        <label for="num_bathrooms" class="form-label">Bagni*</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-bath"></i></span>
                            <input type="number" class="form-control @error('num_bathrooms') is-invalid @enderror"
                                id="num_bathrooms" aria-describedby="num_bathrooms" name="num_bathrooms"
                                value='{{ old('num_bathrooms') ?? $apartment->num_bathrooms }}' min="0" required>
                        </div>
                        @error('num_bathrooms')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row my-3">
                    <div class=" col-6">
                        <label for="full_address" class="form-label">Indirizzo completo*</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-location-dot"></i></span>
                            <input list="addressList" type="text"
                                class="form-control @error('full_address') is-invalid @enderror" id="full_address"
                                aria-describedby="full_address" name="full_address"
                                value='{{ old('full_address') ?? $apartment->full_address }}' maxlength="255" required>
                            <datalist id="addressList">
                            </datalist>
                        </div>
                        @error('full_address')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="square_meters" class="form-label">Metri quadri*</label>
                        <div class="input-group mb-3">
                            <input type="number" step="0.01" min="0"
                                class="form-control @error('square_meters') is-invalid @enderror" id="square_meters"
                                aria-describedby="square_meters" name="square_meters"
                                value='{{ old('square_meters') ?? $apartment->square_meters }}' required>
                            <span class="input-group-text">m<sup>2</sup></span>
                        </div>
                        @error('square_meters')
                            <div class="alert alert-danger mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <figure class="my-3">
                        @if (Str::startsWith($apartment->cover_image, 'https'))
                            <img src="{{ $apartment->cover_image }}" alt="{{ $apartment->slug }}">
                        @else
                            <img src="{{ asset('/storage/' . $apartment->cover_image) }}" alt="{{ $apartment->slug }}">
                        @endif
                    </figure>
                    <label for="cover_image" class="form-label">Immagine di copertina*</label>
                    <input type="file" name="cover_image" id="cover_image"
                        class="form-control
                        @error('cover_image') is-invalid @enderror">
                    @error('cover_image')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="row mt-4" id="moreImagesContainer">
                    <label for="cover_image" class="form-label">Immagine aggiuntive</label>
                    @foreach ($more_images as $index => $image)
                        <div class="col-4 mb-4" id="image-container-{{ $index }}">
                            <input type="hidden" name="image_id[]" id="image_id_{{ $image->id }}"
                                value="{{ $image->id }}">
                            <input type="hidden" name="status[]" id="status_image" value="not_edited">
                            <div class="position-relative">
                                <div class="rounded overflow-hidden">
                                    @if (Str::startsWith($image->path, 'https'))
                                        <img id="selectedImage{{ $index }}" src="{{ $image->path }}"
                                            alt="{{ $image->category }}" class="img-fluid object-fit-cover"
                                            style="height: 161.55px">
                                    @else
                                        <img id="selectedImage{{ $index }}"
                                            src="{{ asset('/storage/' . $image->path) }}" alt="{{ $image->category }}"
                                            class="img-fluid object-fit-cover" style="height: 161.55px">
                                    @endif
                                </div>
                                <div class="position-absolute top-50 start-50 translate-middle">
                                    <div data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-rounded">
                                        <label class="form-label text-white m-1"
                                            for="customFile{{ $index }}">+</label>
                                        <input type="file" name="images[]" class="form-control d-none"
                                            id="customFile{{ $index }}"
                                            onchange="displaySelectedImage(event, 'selectedImage{{ $index }}')" />
                                    </div>
                                    @error('images[]')
                                        <div class="alert alert-danger mt-1">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <form action="{{ route('images.delete', ['id' => $image->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger position-absolute top-0 end-0">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="mt-2 mb-3">
                                <label for="categories[]" class="form-label">Categoria</label>
                                <select
                                    class="form-select form-select-lg
                                    @error('categories[]')
                                        is_invalid
                                    @enderror"
                                    name="categories[]" id="categories_{{ $index }}">
                                    <option value="" selected>Seleziona</option>

                                    @foreach ($categories_images as $item)
                                        <option value="{{ $item }}"
                                            {{ $item == old('category', $image->category) ? 'selected' : '' }}>
                                            {{ ucfirst($item) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach


                    <div class="col-4 mb-4" id="image-container-{{ $more_images->count() }}">
                        <input type="hidden" name="image_id[]" id="none_id_{{ $more_images->count() }}"
                            value="">
                        <input type="hidden" name="status[]" id="status_image{{ $more_images->count() }}"
                            value="">
                        <div class="position-relative">
                            <div class="rounded overflow-hidden">
                                <img id="selectedImage{{ $more_images->count() }}"
                                    src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                                    alt="example placeholder" class="img-fluid object-fit-cover"
                                    style="height: 161.55px" />
                            </div>
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <div data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-rounded">
                                    <label class="form-label text-white m-1"
                                        for="customFile{{ $more_images->count() }}">+</label>
                                    <input type="file" name="images[]" class="form-control d-none"
                                        id="customFile{{ $more_images->count() }}"
                                        onchange="displaySelectedImage(event, 'selectedImage{{ $more_images->count() }}')" />
                                </div>
                                @error('images[]')
                                    <div class="alert alert-danger mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="btn btn-outline-danger position-absolute top-0 end-0 d-none"
                                onclick="removeElement('image-container-{{ $more_images->count() }}')">
                                <i class="fas fa-x"></i>
                            </div>
                        </div>
                        <div class="mt-2 mb-3">
                            <label for="categories[]" class="form-label">Categoria</label>
                            <select
                                class="form-select form-select-lg
                                @error('categories[]')
                                    is_invalid
                                @enderror"
                                name="categories[]" id="categories_{{ $more_images->count() }}" disabled>
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
                                {{ $apartment->services->contains($item->id) || (is_array(old('services')) && in_array($item->id, old('services'))) ? 'checked' : '' }}>
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

                <label class="form-check-label" for="is_available">
                    {!! $apartment->is_available
                        ? "L'appartamento al momento <strong>è visibile</strong>"
                        : "L'appartamento al momento <strong>non è visibile</strong>" !!}
                </label>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_available"
                        name="is_available" {{ old('is_available', $apartment->is_available) ? 'checked' : '' }}
                        onchange="updateLabel()">
                    <label class="form-check-label" for="is_available" id="visibilityLabel">
                    </label>
                    @error('is_available')
                        <div class="alert alert-danger mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit"
                    class="btn gradient-custom-2 border-0 text-light mx-auto d-block mt-3">Modifica</button>
            </form>
        </div>
    </div>

    <script>
        let imageCounter = {{ $more_images->count() + 1 }} || 0;

        function removeElement(elementId) {
            var elementToRemove = document.getElementById(elementId);
            if (!elementToRemove) return; // Exit if the element does not exist

            var fileInput = elementToRemove.querySelector('input[type="file"]');
            var selectElement = elementToRemove.querySelector('select');

            elementToRemove.parentNode.removeChild(elementToRemove);
        }

        document.addEventListener('DOMContentLoaded', function() {

            const categorySelects = document.querySelectorAll('select[name="categories[]"]');

            // Add an event listener to each select element
            categorySelects.forEach(function(selectElement, index) {
                selectElement.addEventListener('change', function(event) {
                    // This function is called whenever a select element is changed

                    // `event.target` refers to the select element that was changed
                    const changedSelect = event.target;

                    // Get the related image_id input for the changed select
                    const parentDiv = changedSelect.closest('.col-4');
                    const statusInput = parentDiv.querySelector('input[name="status[]"]');
                    const imageIdInput = parentDiv.querySelector('input[name="image_id[]"]');

                    if (statusInput.value == "image") {

                        statusInput.value = "both"
                        console.log(statusInput);

                    } else if (statusInput.value == "both") {

                        statusInput.value = "both"
                        console.log(statusInput);

                    } else if (imageIdInput.value == "none") {

                        statusInput.value = "new"
                        console.log(statusInput);
                    } else {
                        statusInput.value = "select"
                        console.log(statusInput);
                    }

                    console.log('Changed select element index:', index);
                    console.log('Associated status:', statusInput.value);

                    // Perform additional actions here based on the change
                    // For example, you can send an AJAX request or update other parts of the UI
                });
            });

            document.getElementById('apartmentForm').addEventListener('change', function(event) {
                if (event.target.name === 'images[]') {
                    const input = event.target;
                    const hasImage = input.files.length > 0;
                    const parentDiv = input.closest('.col-4');

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

            updateLabel();

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
                const uniqueId = 'image-input-' + imageCounter; // ID univoco per il contenitore

                const fileInput = event.target;
                const reader = new FileReader();

                reader.onload = function(e) {
                    if (selectedImage) {
                        selectedImage.src = e.target.result;
                    } else {
                        console.error('Element not found:', elementId);
                    }
                };

                if (fileInput.files && fileInput.files[0]) {
                    reader.readAsDataURL(fileInput.files[0]);
                }

                const parentDiv = selectedImage.closest('.col-4');
                const statusInput = parentDiv.querySelector('input[name="status[]"]');
                const imageIdInput = parentDiv.querySelector('input[name="image_id[]"]');

                console.log(statusInput);

                if (selectedImage.src.startsWith('data:') || selectedImage.src.startsWith(
                        'http://127.0.0.1:8000/storage')) {

                    if (statusInput.value == "select") {

                        statusInput.value = "both"
                        console.log(statusInput);

                    } else if (statusInput.value == "both") {

                        statusInput.value = "both"
                        console.log(statusInput);

                    } else if (imageIdInput.value == "none") {

                        console.log(statusInput);
                    } else {
                        statusInput.value = "image"
                        console.log(statusInput);
                    }

                    return

                } else {

                    imageIdInput.value = "none";
                    statusInput.value = "new"

                    // Altrimenti, crea un nuovo elemento solo se non esiste già
                    const parentElement = document.getElementById('moreImagesContainer');
                    const childElement = document.createElement('div');
                    childElement.classList.add('col-4', 'mb-4');
                    childElement.setAttribute('id', uniqueId);

                    // Utilizza la variabile globale per generare ID univoci
                    const currentImageCounter = imageCounter;

                    console.log('immagine caricata')

                    childElement.innerHTML = `
                        <div class="position-relative">
                            <input type="hidden" name="image_id[]" id="none_id_${currentImageCounter}" value="">
                            <input type="hidden" name="status[]" id="status_image${currentImageCounter}" value="">
                            <div class="rounded overflow-hidden">
                                <img id="selectedImage${currentImageCounter}" src="https://mdbootstrap.com/img/Photos/Others/placeholder.jpg"
                                    alt="example placeholder" class="img-fluid object-fit-cover" style="height: 161.55px"/>
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
                        <div class="mt-2 mb-3">
                            <label for="categories[]" class="form-label">Categoria</label>
                            <select
                                class="form-select form-select-lg
                                @error('categories[]')
                                    is_invalid
                                @enderror"
                                name="categories[]" id="categories_${currentImageCounter}" disabled>
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


        function updateLabel() {
            let checkBox = document.getElementById('is_available');
            let label = document.getElementById('visibilityLabel');
            if (checkBox.checked) {
                label.innerHTML = "Rendi visibile";
                checkBox.value = 1;
            } else {
                label.innerHTML = "Rendi non visibile";
                checkBox.value = 0;
            }
        }
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
