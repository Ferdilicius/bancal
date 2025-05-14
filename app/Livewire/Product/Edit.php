<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;

use App\Models\Product;
use App\Models\ProductCategory;

class Edit extends Component
{
	use WithFileUploads;

	public $product;
	public $name;
	public $description;
	public $quantity;
	public $price;
	public $image;
	public $status;
	public $category_id;
	public $categories;

	public function mount(Product $product)
	{
		$this->product = $product;
		$this->name = $product->name;
		$this->description = $product->description;
		$this->quantity = $product->quantity;
		$this->price = $product->price;
		$this->status = $product->status;
		$this->category_id = $product->category_id;
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

	public function updateProduct()
	{
		$this->validate();

		if ($this->image) {
			$imagePath = $this->image->store('products', 'public');
			$this->product->image = $imagePath;
		}

		$this->product->name = $this->name;
		$this->product->description = $this->description;
		$this->product->quantity = $this->quantity;
		$this->product->price = $this->price;
		$this->product->status = $this->status;
		$this->product->category_id = $this->category_id;

		$this->product->save();

		return redirect()->route('private-profile')->with('success', 'Product updated successfully.');
	}

	public function deleteProduct($productId)
	{
		$product = Product::findOrFail($productId);
		$product->delete();

		return redirect()->route('private-profile')->with('success', 'Product deleted successfully.');
	}

	public function render()
	{
		return view('livewire.product.edit')->layout('layouts.app');
	}
}
