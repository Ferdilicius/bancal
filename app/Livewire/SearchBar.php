<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class SearchBar extends Component
{
    public $searchTerm = '';

    public function render()
    {
        $results = [];
        if (strlen($this->searchTerm) > 1) {
            dd($this->searchTerm);
            $results = Product::where('status', 'activo')
                ->where('name', 'like', '%' . $this->searchTerm . '%')
                ->limit(5)
                ->get();
        }

        return view('livewire.search-bar', [
            'results' => $results,
            'searchTerm' => $this->searchTerm,
        ]);
    }
}