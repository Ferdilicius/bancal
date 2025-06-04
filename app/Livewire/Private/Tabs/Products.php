<?php

namespace App\Livewire\Private\Tabs;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class Products extends Component
{
    public $products;
    public $selectedProducts = [];
    public $selectAll = false;

    public function mount()
    {
        $this->products = Auth::user()->products()->get();
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedProducts = $this->products->pluck('id')->toArray();
        } else {
            $this->selectedProducts = [];
        }
    }

    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);

        foreach ($product->images as $img) {
            if (Storage::disk('public')->exists($img->path)) {
                Storage::disk('public')->delete($img->path);
            }
        }
        $product->images()->delete();
        $product->delete();

        $this->products = Auth::user()->products()->get();
    }

    public function deleteMultipleProducts()
    {
        $products = Product::whereIn('id', $this->selectedProducts)->get();

        foreach ($products as $product) {
            foreach ($product->images as $img) {
                if (Storage::disk('public')->exists($img->path)) {
                    Storage::disk('public')->delete($img->path);
                }
            }
            $product->images()->delete();
            $product->delete();
        }

        $this->selectedProducts = [];
        $this->selectAll = false;

        $this->products = Auth::user()->products()->get();

        session()->flash('message', 'Productos eliminados correctamente.');
    }

    public function updatedSelectedProducts()
    {
        $this->selectAll = count($this->selectedProducts) === $this->products->count();
    }

    public function duplicateProduct($id)
    {
        $original = Product::findOrFail($id);

        $copy = $original->replicate();
        $copy->name = $original->name . ' (Copia)';
        $copy->push();

        foreach ($original->images as $image) {
            $copy->images()->create(['path' => $image->path]);
        }

        $this->products = Auth::user()->products()->get();

        session()->flash('message', 'Producto duplicado correctamente.');
    }


    public function render()
    {
        return view('livewire.private.tabs.products');
    }
}
