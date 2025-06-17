<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'quantity',
        'quantity_type',
        'user_id',
        'image',
        'status',
        'category_id',
        'allow_fractional',
        'max_per_person',
        'min_per_person'
    ];

    public function getFormattedQuantityAttribute()
    {
        $type = $this->quantity_type;
        $quantity = $this->quantity;

        if ($type === 'unidad') {
            $pluralType = $quantity == 1 ? 'unidad' : 'unidades';
            return "{$quantity} {$pluralType}";
        }

        if ($type === 'kilo' && $quantity < 1) {
            // Convert kilos to gramos
            $grams = $quantity * 1000;
            $pluralType = $grams == 1 ? 'gramo' : 'gramos';
            return "{$grams} {$pluralType}";
        }

        $pluralType = $quantity == 1 ? $type : $type . 's';
        return "{$quantity} {$pluralType}";
    }

    public function getFormattedPriceAttribute()
    {
        return "{$this->price} €";
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
