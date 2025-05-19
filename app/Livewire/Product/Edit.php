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
	public $images = [];
	public $existingImages = [];

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

		$this->existingImages = json_decode($product->image, true) ?? [];
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

	public function updateProduct()
	{
		$this->validate();

		$imagePaths = $this->existingImages;

		if ($this->images) {
			foreach ($this->images as $image) {
				$imagePaths[] = $image->store('product-photos', 'public');
			}
		}

		$this->product->update([
			'name' => $this->name,
			'description' => $this->description,
			'quantity' => $this->quantity,
			'price' => $this->price,
			'status' => $this->status,
			'category_id' => $this->category_id,
		]);

		redirect()->route('private-profile');
	}

	public function render()
	{
		return view('livewire.product.edit')->layout('layouts.app');
	}
}
