<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Product;
use App\Models\ProductCategory;

class ProductCrud extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $quantity;
    public $price;
    public $image;
    public $status;
    public $category_id;
    public $categories;
    public $productId;

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
        'image' => 'nullable|image|max:2048',
        'status' => 'required|boolean',
        'category_id' => 'required|exists:product_categories,id',
    ];

    public function storeProduct()
    {
        $this->validate();

        $imagePath = $this->image ? $this->image->store('products', 'public') : null;

        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'image' => $imagePath,
            'status' => $this->status,
            'user_id' => auth()->id(),
            'category_id' => $this->category_id,
        ]);

        session()->flash('success', 'Product created successfully.');
        $this->resetInputFields();
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->name = $product->name;
        $this->description = $product->description;
        $this->quantity = $product->quantity;
        $this->price = $product->price;
        $this->status = $product->status;
        $this->category_id = $product->category_id;
    }

    public function updateProduct()
    {
        $this->validate();

        $product = Product::findOrFail($this->productId);

        $imagePath = $this->image ? $this->image->store('products', 'public') : $product->image;

        $product->update([
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'image' => $imagePath,
            'status' => $this->status,
            'category_id' => $this->category_id,
        ]);

        session()->flash('success', 'Product updated successfully.');
        $this->resetInputFields();
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        session()->flash('success', 'Product deleted successfully.');
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->quantity = '';
        $this->price = '';
        $this->image = null;
        $this->status = false;
        $this->category_id = '';
        $this->productId = null;
    }

    public function render()
    {
        $products = Product::all();
        return view('livewire.product-crud', compact('products'))->layout('layouts.app');
    }
}
