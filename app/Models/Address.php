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
        'image',
        'status',
        'user_id',
        'address_type_id',
    ];

    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
