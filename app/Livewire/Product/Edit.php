<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithFileUploads;

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

	protected $rules = [
		'name' => 'required|string|max:255',
		'description' => 'nullable|string',
		'quantity' => 'required|integer|min:0',
		'price' => 'required|numeric|min:0',
		'image' => 'nullable|image|max:1024',
		'status' => 'required|boolean',
	];

	public function mount(Product $product)
	{
		$this->product = $product;
		$this->name = $product->name;
		$this->description = $product->description;
		$this->quantity = $product->quantity;
		$this->price = $product->price;
		$this->status = $product->status;
	}

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

		$this->product->save();

		session()->flash('success', 'Product updated successfully.');

		return redirect()->route('my-account');
	}

	public function render()
	{
		return view('livewire.product.edit')->layout('layouts.app');
	}
}
