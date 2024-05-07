<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApartmentController extends Controller
{
    public function index(Request $request)
    {
        $pagination_value = $this->determinePagination($request->input('from_where'));
        $category = $request->input('category');
        $now = Carbon::now();

        $query = Apartment::with('services')
            ->leftJoin('apartment_sponsorship', function ($join) {
                $join->on('apartments.id', '=', 'apartment_sponsorship.apartment_id')
                    ->whereRaw('apartment_sponsorship.created_at = (
                        SELECT MAX(created_at) FROM apartment_sponsorship
                        WHERE apartment_id = apartments.id
                     )');
            })
            ->select('apartments.*', 'apartment_sponsorship.expiration_date')
            ->where('is_available', 1)
            ->whereNull('deleted_at')
            ->when($category, function ($query, $category) {
                return $query->where('category', $category);
            });

        if ($request->input('from_where') === 'advancedSearch') {
            $apartments = $query
                ->orderByRaw('CASE WHEN apartment_sponsorship.expiration_date > ? THEN 0 ELSE 1 END', [$now])
                ->orderByDesc('apartment_sponsorship.created_at')
                ->orderBy('apartments.created_at')
                ->paginate($pagination_value);
        } else {
            $apartments = $query
                ->where('apartment_sponsorship.expiration_date', '>', $now)
                ->orderByDesc('apartment_sponsorship.created_at')
                ->paginate($pagination_value);
        }

        $services = Service::all();

        return response()->json([
            'success' => true,
            'apartments' => $apartments,
            'services' => $services
        ]);
    }

    public function filter(Request $request)
    {
        $pagination_value = $this->determinePagination($request->input('from_where'));
        $now = Carbon::now();

        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius') * 1000; // Convert km to meters directly here

        $query = Apartment::with('services')
            ->leftJoin('apartment_sponsorship', function ($join) {
                $join->on('apartments.id', '=', 'apartment_sponsorship.apartment_id')
                    ->whereRaw('apartment_sponsorship.created_at = (
                     SELECT MAX(created_at) FROM apartment_sponsorship
                     WHERE apartment_id = apartments.id
                 )');
            })
            ->select('apartments.*', 'apartment_sponsorship.expiration_date')
            ->where('is_available', 1)
            ->whereNull('deleted_at');

        // Apply filters based on request inputs
        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->where('category', $request->input('category'));
        });

        $query->when($request->filled('num_beds'), function ($q) use ($request) {
            $q->where('num_beds', '>=', $request->input('num_beds'));
        });

        $query->when($request->filled('num_rooms'), function ($q) use ($request) {
            $q->where('num_rooms', '>=', $request->input('num_rooms'));
        });

        $query->when(!empty($request->input('services', [])), function ($q) use ($request) {
            foreach ($request->input('services', []) as $service) {
                $q->whereHas('services', function ($subQuery) use ($service) {
                    $subQuery->where('services.id', $service);
                });
            }
        });

        if ($latitude && $longitude && $radius) {
            $query->addSelect(DB::raw("
            (6371000 * acos(
                cos(radians($latitude)) * cos(radians(latitude)) * cos(radians(longitude) - radians($longitude))
                + sin(radians($latitude)) * sin(radians(latitude))
            )) AS distance
        "))
                ->having('distance', '<=', $radius);
        }

        // Ordering for sponsorship status first, then distance if applicable
        $query->orderByRaw('CASE WHEN apartment_sponsorship.expiration_date > ? THEN 0 ELSE 1 END', [$now]);

        if ($latitude && $longitude && $radius) {
            $query->orderBy('distance');
        }

        $query->orderByDesc('apartment_sponsorship.created_at')
            ->orderBy('apartments.created_at');

        $apartments = $query->paginate($pagination_value);

        return response()->json([
            'success' => true,
            'apartments' => $apartments
        ]);
    }


    public function show($slug)
    {
        $apartment = Apartment::with('services')->where('is_available', 1)->where('slug', $slug)->first();

        if ($apartment) {
            return response()->json([
                'success' => true,
                'apartment' => $apartment,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => "L'appartamento selezionato non esiste"
            ]);
        }
    }

    private function determinePagination($fromWhere)
    {
        switch ($fromWhere) {
            case 'homePage':
                return 12;
            case 'advancedSearch':
                return 51;
            default:
                return 10; // Default pagination value if from_where is not recognized
        }
    }
}
