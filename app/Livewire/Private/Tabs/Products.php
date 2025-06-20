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

    public function mount()
    {
        $this->products = Auth::user()->products()->get();
    }

    public function deleteProduct($productId)
    {
        $product = Product::findOrFail($productId);

        foreach ($product->images as $img) {
            $fullPath = 'model_images/' . $img->path;
            if (Storage::disk('local')->exists($fullPath)) {
                Storage::disk('local')->delete($fullPath);
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
                $fullPath = 'model_images/' . $img->path;
                if (Storage::disk('local')->exists($fullPath)) {
                    Storage::disk('local')->delete($fullPath);
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
            $originalPath = 'model_images/' . $image->path;
            $extension = pathinfo($image->path, PATHINFO_EXTENSION);
            $newFilename = pathinfo($image->path, PATHINFO_FILENAME) . '_copy_' . uniqid() . '.' . $extension;
            $newPath = 'model_images/' . $newFilename;

            if (Storage::disk('local')->exists($originalPath)) {
                Storage::disk('local')->copy($originalPath, $newPath);
                $copy->images()->create([
                    'path' => $newFilename,
                    'order' => $image->order ?? 0,
                ]);
            }
        }

        $this->products = Auth::user()->products()->get();
    }

    public function render()
    {
        return view('livewire.private.tabs.products');
    }
}
