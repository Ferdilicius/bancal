<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;

class Show extends Component
{
    public $product;

    public function mount($productId)
    {
        $this->product = Product::where('id', $productId)
            ->where(function ($query) {
                $query->where('status', 'activo')
                    ->orWhere(function ($q) {
                        $q->where('status', 'inactivo')
                            ->where('user_id', auth()->id());
                    });
            })
            ->first();

        if (!$this->product) {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.product.show')->layout('layouts.app');
    }
}
