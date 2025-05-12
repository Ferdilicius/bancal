<?php

namespace App\Livewire\Product;

use Livewire\Component;

class Edit extends Component
{
	public $product;

	public function mount($product)
	{
		$this->product = $product;
	}

	public function save()
	{
		// Add logic to save the product
	}

	public function render()
	{
		return view('livewire.product.edit')->layout('layouts.app');
	}
}
