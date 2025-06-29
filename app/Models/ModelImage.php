<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelImage extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'path', 'order'];

    protected $casts = [
        'order' => 'integer',
    ];

    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($query) {
            $query->orderBy('order');
        });
    }

    public function imageable()
    {
        return $this->morphTo();
    }
}
