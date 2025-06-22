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
            $searchTerm = str_replace(',', '.', $this->searchTerm);

            $this->results = Product::where('status', 'activo')
                ->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhere('description', 'like', '%' . $searchTerm . '%')
                        ->orWhere('quantity', 'like', '%' . $searchTerm . '%')
                        ->orWhere('price', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('category', function ($q) use ($searchTerm) {
                            $q->where('id', 'like', '%' . $searchTerm . '%')
                                ->orWhere('name', 'like', '%' . $searchTerm . '%');
                        });
                })
                ->with('user')
                ->get()
                ->sortBy(function ($product) use ($searchTerm) {
                    $fields = [
                        $product->name,
                        $product->description,
                        (string) $product->quantity,
                        (string) $product->price,
                    ];
                    $positions = array_map(function ($field) use ($searchTerm) {
                        return stripos($field, $searchTerm);
                    }, $fields);
                    $validPositions = array_filter($positions, function ($pos) {
                        return $pos !== false;
                    });
                    return !empty($validPositions) ? min($validPositions) : PHP_INT_MAX;
                })
                ->take(5)
                ->values();
        }

        return view('livewire.search-bar');
    }
}
