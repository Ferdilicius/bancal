<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'provider',
        'account_name',
        'account_number',
        'expiration',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


