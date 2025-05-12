<?php

namespace App\Livewire\Product;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;

class Create extends Component
{
    use WithFileUploads;

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
        'image' => 'nullable|image|max:1024', // Máximo 1MB
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

        return redirect()->route('my-account');
    }

    public function render()
    {
        return view('livewire.product.create')->layout('layouts.app');
    }
}
