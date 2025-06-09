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

        // Handle irregular plural for "unidad"
        if ($type === 'unidad') {
            $pluralType = $quantity == 1 ? 'unidad' : 'unidades';
        } else {
            $pluralType = $quantity == 1 ? $type : $type . 's';
        }

        return "{$quantity} {$pluralType}";
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
