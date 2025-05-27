<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductCategory;

use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
	use WithFileUploads;

	public $product;
	public $name;
	public $description;
	public $quantity;
	public $price;
	public $images = [];
	public $newImages = [];
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
		$this->status = $product->status === 'activo';
		$this->category_id = $product->category_id;
		$this->categories = ProductCategory::all();
		$this->images = $product->images->pluck('path')->toArray();
	}

	protected $rules = [
		'name' => 'required|string|max:255',
		'description' => 'nullable|string',
		'quantity' => 'required|integer|min:0',
		'quantity_type' => 'required|in:litros,kilos,unidades,bolsas,cajas',
		'price' => 'required|numeric|min:0',
		'newImages.*' => 'nullable|image|max:2048',
		'status' => 'required|boolean',
		'category_id' => 'required|exists:product_categories,id',
	];

	public function updatedNewImages()
	{
		foreach ($this->newImages as $file) {
			$this->images[] = $file;
		}
		$this->newImages = [];
	}

	public function removeImage($index)
	{
		// Si es string, es una imagen existente
		if (is_string($this->images[$index])) {
			$imageModel = $this->product->images()->where('path', $this->images[$index])->first();
			if ($imageModel) {
				$imageModel->delete();
			}
		}
		unset($this->images[$index]);
		$this->images = array_values($this->images);
	}

	public function moveImage($fromIndex, $toIndex)
	{
		if (!isset($this->images[$fromIndex]) || !isset($this->images[$toIndex])) return;

		$moved = $this->images[$fromIndex];
		array_splice($this->images, $fromIndex, 1);
		array_splice($this->images, $toIndex, 0, [$moved]);
		$this->images = array_values($this->images);
	}

	public function updateProduct()
	{
		$this->validate();

		$this->product->update([
			'name' => $this->name,
			'description' => $this->description,
			'quantity' => $this->quantity,
			'price' => $this->price,
			'status' => $this->status ? 'activo' : 'inactivo',
			'category_id' => $this->category_id,
		]);

		foreach ($this->images as $index => $image) {
			if ($image instanceof \Illuminate\Http\UploadedFile) {
				// Nueva imagen, la guardamos y la creamos
				$path = $image->store('product-photos', 'public');
				$this->product->images()->create([
					'path' => $path,
					'order' => $index,
				]);
			} else {
				// Imagen existente, solo actualizamos el orden
				$imageModel = $this->product->images()->where('path', $image)->first();
				if ($imageModel) {
					$imageModel->order = $index;
					$imageModel->save();
				}
			}
		}

		return redirect()->route('private-profile');
	}


	public function deleteProduct()
	{
		// Eliminar imágenes asociadas
		foreach ($this->product->images as $image) {
			// Elimina el archivo físico si existe
			if (Storage::disk('public')->exists($image->path)) {
				Storage::disk('public')->delete($image->path);
			}
			$image->delete();
		}

		return redirect()->route('private-profile');
	}

	public function render()
	{
		return view('livewire.product.edit')->layout('layouts.app');
	}
}
