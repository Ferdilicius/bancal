<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class SearchBar extends Component
{
    public $searchTerm = '';
    public $results = [];

    public function render()
    {
        if (strlen($this->searchTerm) >= 1) {
            $this->results = Product::where('status', 'activo')
                ->where('name', 'like', '%' . $this->searchTerm . '%')
                ->with('user')
                ->get()
                ->sortByDesc(function ($product) {
                    return $product->user && $product->user->user_type === 'empresa';
                })
                ->take(5)
                ->values();
        }

        return view('livewire.search-bar');
    }
}
