<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $fillable = [
        'amount',
        'name',
        'duration',
    ];
    
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class, 'apartment_sponsorship');
    }
}
