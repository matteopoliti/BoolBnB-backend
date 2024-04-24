<?php

namespace App\Http\Requests;

use App\Models\Apartment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateApartmentRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:100', Rule::unique('apartments')->ignore($this->apartment)],
            'category' => ['required', Rule::in(["villa", "apartment", "agriturismo", "baita", "castello", "loft", "mobile house"])],
            'price' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'num_rooms' => ['required', 'integer', 'min:0'],
            'num_beds' => ['required', 'integer', 'min:0'],
            'num_bathrooms' => ['required', 'integer', 'min:0'],
            'square_meters' => ['required', 'numeric', 'min:0'],
            'full_address' => ['required', 'string', 'max:255'],
            'cover_image' => ['image'],
            'services' => ['required', 'exists:services,id'],
        ];
    }
}
