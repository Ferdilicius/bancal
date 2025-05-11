<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class Products extends Component
{
    public $products = [];

    public function mount()
    {
        $this->products = Product::where('status', 1)->get();
    }

    public function render()
    {
        return view('livewire.products')->layout('layouts.app');
    }
}
