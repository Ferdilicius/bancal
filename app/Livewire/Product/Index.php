<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Product;
use App\Models\ProductCategory;

class Index extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $category_id = '';
    public $quantity_type = '';
    public $orderBy = 'created_at_desc';

    protected $listeners = [
        'searchUpdated' => 'setSearchTerm',
        'filtersChanged' => 'setFilters',
    ];

    public function setSearchTerm($term)
    {
        $this->searchTerm = $term;
        $this->resetPage();
    }

    public function updatingSearchTerm()
    {
        $this->resetPage();
    }

    public function setFilters($filters)
    {
        $this->category_id = $filters['category_id'] ?? '';
        $this->quantity_type = $filters['quantity_type'] ?? '';
        $this->orderBy = $filters['orderBy'] ?? 'created_at_desc';
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['searchTerm', 'category_id', 'quantity_type', 'orderBy']);
        $this->orderBy = 'created_at_desc';
        $this->resetPage();
    }

    public function render()
    {
        $categories = ProductCategory::all();

        $products = Product::where('status', 'activo')
            ->when($this->searchTerm, fn($q) => $q->where('name', 'like', $this->searchTerm . '%'))
            ->when($this->category_id, fn($q) => $q->where('category_id', $this->category_id))
            ->when($this->quantity_type, fn($q) => $q->where('quantity_type', $this->quantity_type))
            ->when($this->orderBy, function ($q) {
                switch ($this->orderBy) {
                    case 'created_at_asc':
                        $q->orderBy('created_at', 'asc');
                        break;
                    case 'price_asc':
                        $q->orderBy('price', 'asc');
                        break;
                    case 'price_desc':
                        $q->orderBy('price', 'desc');
                        break;
                    case 'name_asc':
                        $q->orderBy('name', 'asc');
                        break;
                    case 'name_desc':
                        $q->orderBy('name', 'desc');
                        break;
                    default:
                        $q->orderBy('created_at', 'desc');
                }
            })
            ->paginate(10);

        return view('livewire.product.index', compact('products', 'categories'))->layout('layouts.app');
    }
}
