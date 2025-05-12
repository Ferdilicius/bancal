<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'description', 'quantity', 'user_id', 'image', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
