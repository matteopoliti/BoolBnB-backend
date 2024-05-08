<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function delete($id)
    {
        $image = Image::find($id);

        $apartmentId = $image->apartment_id;

        $apartment = Apartment::find($apartmentId);

        Storage::delete($image->path);

        $image->delete();

        return redirect()->route('dashboard.apartments.show', $apartment->slug);
    }
}
