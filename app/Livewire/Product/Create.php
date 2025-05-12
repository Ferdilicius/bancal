<?php

namespace App\Livewire\Product;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $description;
    public $quantity;
    public $price;
    public $image;
    public $status;
    public $user_id;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'quantity' => 'required|integer|min:0',
        'price' => 'required|numeric|min:0',
        'image' => 'nullable|image|max:1024',
        'status' => 'required|boolean',
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
        ]);

        session()->flash('message', 'Producto creado exitosamente.');

        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['name', 'description', 'quantity', 'price', 'image', 'status']);
    }

    public function render()
    {
        return view('livewire.product.create')->layout('layouts.app');
    }
}
