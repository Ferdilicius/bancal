<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Storage;

class Crud extends Component
{
    use WithFileUploads;

    public $productId;
    public $name;
    public $description;
    public $quantity;
    public $quantity_type;
    public $quantityTypes;
    public $price;
    public $images = [];
    public $newImages = [];
    public $status;
    public $category_id;
    public $categories;
    public $product;

    // Nuevos campos
    public $allow_fractional = false;
    public $max_per_person;
    public $min_per_person;

    public function mount($productId = null)
    {
        $this->categories = ProductCategory::all();
        $this->quantityTypes = ['litro', 'kilo', 'unidad', 'bolsa', 'caja'];
        $this->status = false;

        if ($productId) {
            $this->productId = $productId;
            $this->product = Product::with('images')->findOrFail($productId);
            $this->name = $this->product->name;
            $this->description = $this->product->description;
            $this->quantity = $this->product->quantity;
            $this->quantity_type = $this->product->quantity_type;
            $this->price = $this->product->price;
            $this->status = $this->product->status === 'activo';
            $this->category_id = $this->product->category_id;
            $this->images = $this->product->images->pluck('path')->toArray();
            // Nuevos campos
            $this->allow_fractional = $this->product->allow_fractional;
            $this->max_per_person = $this->product->max_per_person;
            $this->min_per_person = $this->product->min_per_person;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|numeric|min:0',
            'quantity_type' => 'required|in:litro,kilo,unidad,bolsa,caja',
            'price' => 'required|numeric|min:0',
            'images.*' => 'nullable',
            'newImages.*' => 'nullable|image|max:2048',
            'status' => 'required|boolean',
            'category_id' => 'required|exists:product_categories,id',
            'allow_fractional' => 'required|boolean',
            'max_per_person' => 'nullable|numeric|min:0',
            'min_per_person' => 'nullable|numeric|min:0',
        ];
    }

    public function updatedNewImages()
    {
        foreach ($this->newImages as $file) {
            $this->images[] = $file;
        }
        $this->newImages = [];
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

            if (is_string($image) && $this->productId) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
                $product = Product::find($this->productId);
                if ($product) {
                    $product->images()->where('path', $image)->delete();
                }
            }

            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->productId) {
            $product = Product::findOrFail($this->productId);
            $product->update([
                'name' => $this->name,
                'description' => $this->description,
                'quantity' => $this->quantity,
                'quantity_type' => $this->quantity_type,
                'price' => $this->price,
                'status' => $this->status ? 'activo' : 'inactivo',
                'category_id' => $this->category_id,
                'allow_fractional' => $this->allow_fractional,
                'max_per_person' => $this->max_per_person,
                'min_per_person' => $this->min_per_person,
            ]);
        } else {
            $product = Product::create([
                'name' => $this->name,
                'description' => $this->description,
                'quantity' => $this->quantity,
                'quantity_type' => $this->quantity_type,
                'price' => $this->price,
                'status' => $this->status ? 'activo' : 'inactivo',
                'user_id' => auth()->id(),
                'category_id' => $this->category_id,
                'allow_fractional' => $this->allow_fractional,
                'max_per_person' => $this->max_per_person,
                'min_per_person' => $this->min_per_person,
            ]);
            $this->productId = $product->id;
        }

        // Guardar imágenes nuevas
        $order = 0;
        foreach ($this->images as $image) {
            if (is_object($image)) {
                $path = $image->store('product-photos', 'public');
                $product->images()->create([
                    'path' => $path,
                    'order' => $order++,
                ]);
            } elseif (is_string($image)) {
                $img = $product->images()->where('path', $image)->first();
                if ($img) {
                    $img->order = $order++;
                    $img->save();
                }
            }
        }

        return redirect()->route('private-profile');
    }

    public function delete()
    {
        if ($this->productId) {
            $product = Product::findOrFail($this->productId);
            foreach ($product->images as $img) {
                if (Storage::disk('public')->exists($img->path)) {
                    Storage::disk('public')->delete($img->path);
                }
            }
            $product->images()->delete();
            $product->delete();
        }
        return redirect()->route('private-profile');
    }

    public function render()
    {
        return view('livewire.product.save')->layout('layouts.app');
    }
}
