<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $products = Product::where('status', 'activo')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.product.index', compact('products'))
            ->layout('layouts.app');
    }
}
