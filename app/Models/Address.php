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
        'status',
        'latitude',
        'longitude',
        'geometry',
        'user_id',
        'address_type_id',
    ];

    protected $casts = [
        'geometry' => 'array',
    ];

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
