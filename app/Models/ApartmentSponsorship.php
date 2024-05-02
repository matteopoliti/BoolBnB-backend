<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApartmentSponsorship extends Model
{
    use HasFactory;

    protected $table = 'apartment_sponsorship'; // Confirm the table name

    protected $fillable = [
        'apartment_id',
        'sponsorship_id'
    ];

    protected $casts = [
        'created_at' => 'datetime', // Cast to datetime to ensure handling as Carbon instance
        'updated_at' => 'datetime', // Also cast updated_at for consistency
    ];

    /**
     * Get the apartment associated with the ApartmentSponsorship.
     */
    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id');
    }

    /**
     * Get the sponsorship associated with the ApartmentSponsorship.
     */
    public function sponsorship()
    {
        return $this->belongsTo(Sponsorship::class, 'sponsorship_id');
    }
}
