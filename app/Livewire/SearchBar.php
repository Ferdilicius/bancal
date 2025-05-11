<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class SearchBar extends Component
{
    public $searchTerm = '';
    public $searchResults = [];

    public function updatedSearchTerm()
    {
        $this->searchResults = Product::query()
            ->where('name', 'like', '%' . $this->searchTerm . '%')
            ->get();
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}
