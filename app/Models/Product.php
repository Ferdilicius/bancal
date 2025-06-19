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
        'status',
        'allow_fractional',
        'max_per_person',
        'min_per_person',
        'address_id',
        'user_id',
        'category_id',
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

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function images()
    {
        return $this->morphMany(ModelImage::class, 'imageable')->orderBy('order');
    }
}
