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
        'min_per_person',
        'max_per_person',
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

        $pluralType = $quantity == 1 ? $type : $type . 's';
        return "{$quantity} {$pluralType}";
    }

    public function getFormattedMinPerPersonAttribute()
    {
        $min = $this->min_per_person;
        $type = $this->quantity_type;

        if ($type === 'unidad') {
            $pluralType = $min == 1 ? 'unidad' : 'unidades';
            return "{$min} {$pluralType}";
        }

        $pluralType = $min == 1 ? $type : $type . 's';
        return "{$min} {$pluralType}";
    }

    public function getFormattedMaxPerPersonAttribute()
    {
        $max = $this->max_per_person;
        $type = $this->quantity_type;

        if ($type === 'unidad') {
            $pluralType = $max == 1 ? 'unidad' : 'unidades';
            return "{$max} {$pluralType}";
        }

        $pluralType = $max == 1 ? $type : $type . 's';
        return "{$max} {$pluralType}";
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

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
