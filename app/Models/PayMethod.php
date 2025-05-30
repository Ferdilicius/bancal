<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'name',
        'description'
    ];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}
