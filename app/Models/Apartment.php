<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use HasFactory;
    use SoftDeletes;

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

    protected $casts = [
        'deleted_at' => 'datetime', // Cast to datetime to ensure handling as Carbon instance
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function sponsorships(): BelongsToMany
    {
        return $this->belongsToMany(Sponsorship::class, 'apartment_sponsorship');
    }
}
