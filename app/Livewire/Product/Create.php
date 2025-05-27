<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductCategory;

use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $quantity;
    public $price;
    public $images = [];
    public $newImages = [];
    public $status;
    public $category_id;
    public $categories;

    public function mount()
    {
        $this->status = false;
        $this->categories = ProductCategory::all();
    }

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'images.*' => 'nullable|image|max:2048',
        'status' => 'required|boolean',
        'category_id' => 'required|exists:product_categories,id',
    ];

    public function updatedNewImages()
    {
        foreach ($this->newImages as $file) {
            $this->images[] = $file;
        }

        $this->newImages = []; // Limpia buffer
    }

    public function moveImage($fromIndex, $toIndex)
    {
        if (!isset($this->images[$fromIndex]) || !isset($this->images[$toIndex])) return;

        $moved = $this->images[$fromIndex];
        array_splice($this->images, $fromIndex, 1);
        array_splice($this->images, $toIndex, 0, [$moved]);
        $this->images = array_values($this->images);
    }

    public function removeImage($index)
    {
        if (isset($this->images[$index])) {
            $image = $this->images[$index];

            if (is_string($image)) {
                // Elimina el archivo del disco
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }

                // Elimina el registro de la base de datos
                $this->product->images()->where('path', $image)->delete();
            }

            // Elimina la referencia del array
            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }

    public function storeProduct()
    {
        $this->validate();

        $product = Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'status' => $this->status ? 'activo' : 'inactivo',
            'user_id' => auth()->id(),
            'category_id' => $this->category_id,
        ]);

        foreach ($this->images as $index => $image) {
            $path = $image->store('product-photos', 'public');
            $product->images()->create([
                'path' => $path,
                'order' => $index,
            ]);
        }

        return redirect()->route('private-profile');
    }

    public function render()
    {
        return view('livewire.product.create')->layout('layouts.app');
    }
}
