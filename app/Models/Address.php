<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'name',
        'image',          // Del primer modelo
        'status',
        'latitude',
        'longitude',
        'geometry',      // Del segundo modelo
        'user_id',
        'address_type_id',
    ];

    protected $casts = [
        'geometry' => 'array', // Del segundo modelo
    ];

    // Relaciones (comunes a ambos modelos)
    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->morphMany(ModelImage::class, 'imageable')->orderBy('order');
    }
}