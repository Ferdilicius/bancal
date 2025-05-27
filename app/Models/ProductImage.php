<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
