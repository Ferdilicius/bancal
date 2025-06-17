<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class SearchBar extends Component
{
    public $searchTerm = '';
    public $showResults = true;
    public $results = [];

    public function mount($showResults = true)
    {
        $this->showResults = $showResults;
    }

    public function updatedSearchTerm()
    {
        if (!$this->showResults) {
            $this->dispatch('searchUpdated', $this->searchTerm);
        }
    }

    public function render()
    {
        if ($this->showResults && strlen($this->searchTerm) >= 1) {
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
