<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;

class Index extends Component
{
    use WithPagination;

    public $searchTerm = '';

    protected $listeners = ['searchUpdated' => 'setSearchTerm'];

    public function setSearchTerm($term)
    {
        $this->searchTerm = $term;
        $this->resetPage();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function render()
    {
        $products = Product::where('status', 'activo')
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.product.index', compact('products'))
            ->layout('layouts.app');
    }
}
