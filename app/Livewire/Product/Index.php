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
    public $min_price = '';
    public $max_price = '';
    public $quantity_type = '';

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

    public function updating($name)
    {
        if (in_array($name, ['category_id', 'min_price', 'max_price', 'quantity_type'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $categories = ProductCategory::all();

        $products = Product::where('status', 'activo')
            ->when($this->searchTerm, function ($query) {
                $query->where('name', 'like', '%' . $this->searchTerm . '%');
            })
            ->when($this->category_id, function ($query) {
                $query->where('category_id', $this->category_id);
            })
            ->when($this->quantity_type, function ($query) {
                $query->where('quantity_type', $this->quantity_type);
            })
            ->when($this->min_price !== '', function ($query) {
                $query->where('price', '>=', $this->min_price);
            })
            ->when($this->max_price !== '', function ($query) {
                $query->where('price', '<=', $this->max_price);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.product.index', compact('products', 'categories'))
            ->layout('layouts.app');
    }
}
