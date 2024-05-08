<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:100', 'unique:apartments,title'],
            'category' => ['required', Rule::in(["villa", "appartamento", "agriturismo", "baita", "castello", "loft", "roulotte"])],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'num_rooms' => ['required', 'integer', 'min:0'],
            'num_beds' => ['required', 'integer', 'min:0'],
            'num_bathrooms' => ['required', 'integer', 'min:0'],
            'square_meters' => ['required', 'numeric', 'min:0'],
            'full_address' => ['required', 'string', 'max:255'],
            'cover_image' => ['required', 'image'],
            'services' => ['required', 'exists:services,id'],
            'categories.*' => ['sometimes', 'nullable', Rule::in(['soggiorno', 'cucina', 'bagno', 'camera da letto', 'garage', 'giardino', 'varie'])],
            'images.*' => ['sometimes', 'image'],
        ];
    }
}
