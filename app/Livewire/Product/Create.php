<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Product;
use App\Models\ProductCategory;

class Create extends Component
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

        return redirect()->route('private-profile')->with('success', 'Product created successfully.');
    }

    public function render()
    {
        return view('livewire.product.create')->layout('layouts.app');
    }
}
