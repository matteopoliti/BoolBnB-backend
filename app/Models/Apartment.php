<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'category',
        'price',
        'description',
        'num_rooms',
        'num_beds',
        'num_bathrooms',
        'square_meters',
        'full_address',
        'latitude',
        'longitude',
        'cover_image',
        'is_available',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
