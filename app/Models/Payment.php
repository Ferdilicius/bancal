<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'method',
        'payment_intent_id',
        'status',
        'amount',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
