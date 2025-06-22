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
    public $imagesToDelete = [];
    public $status;
    public $category_id;
    public $categories;
    public $product;
    public $allow_fractional = false;
    public $max_per_person;
    public $min_per_person;

    // 1. Añade la propiedad pública
    public $address_id;
    public $addresses; // Opcional: para listar direcciones

    public function mount($productId = null)
    {
        $this->categories = ProductCategory::all();
        $this->quantityTypes = ['gramo', 'kilo', 'unidad', 'litro', 'bolsa', 'caja'];
        $this->status = false;
        // Solo direcciones cuyo address_type no sea 'privado'
        $this->addresses = auth()->user()
            ? auth()->user()->addresses()->whereHas('addressType', function ($q) {
                $q->where('name', '!=', 'privado');
            })->get()
            : collect();

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
            $this->allow_fractional = $this->product->allow_fractional;
            $this->max_per_person = $this->product->max_per_person;
            $this->min_per_person = $this->product->min_per_person;
            // 3. Carga el address_id del producto
            $this->address_id = $this->product->address_id;
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'quantity_type' => 'required|in:gramo,kilo,unidad,litro,bolsa,caja',
            'price' => [
                'required',
                'numeric',
                'min:0',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'images.*' => 'nullable',
            'newImages.*' => 'nullable|image|max:2048',
            'status' => 'required|boolean',
            'category_id' => 'required|exists:product_categories,id',
            'allow_fractional' => 'required|boolean',
            'max_per_person' => 'nullable|numeric|min:0',
            'min_per_person' => 'nullable|numeric|min:0',
            'address_id' => 'required|exists:addresses,id',
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
                $this->imagesToDelete[] = $image;
            }

            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }

    public function updatedMinPerPerson($value)
    {
        // Si es null, vacío o menor que 0, poner null. Si es 0, poner 1.
        if ($value === null || $value === '') {
            $this->min_per_person = null;
        } elseif ($value <= 0) {
            $this->min_per_person = 1;
        } elseif ($value > $this->quantity) {
            $this->min_per_person = $this->quantity;
        } else {
            $this->min_per_person = $value;
        }

        // Si max_per_person es menor que min, ajústalo
        if ($this->max_per_person !== null && $this->max_per_person < $this->min_per_person) {
            $this->max_per_person = $this->min_per_person;
        }
    }

    public function updatedMaxPerPerson($value)
    {
        // No puede ser negativo, menor que min, ni mayor que cantidad
        if ($value === null || $value === '' || $value <= 0) {
            $this->max_per_person = null;
        } elseif ($this->min_per_person !== null && $value < $this->min_per_person) {
            $this->max_per_person = $this->min_per_person;
        } elseif ($value > $this->quantity) {
            $this->max_per_person = $this->quantity;
        } else {
            $this->max_per_person = $value;
        }
    }

    public function updatedQuantity($value)
    {
        // Si cambias la cantidad, ajusta min y max si hace falta
        if ($this->min_per_person !== null && $this->min_per_person > $value) {
            $this->min_per_person = $value;
        }
        if ($this->max_per_person !== null && $this->max_per_person > $value) {
            $this->max_per_person = $value;
        }
    }

    public function save()
    {
        $this->validate();

        // Validación extra por si acaso
        if ($this->min_per_person !== null && $this->min_per_person > $this->quantity) {
            $this->addError('min_per_person', 'El mínimo por persona no puede ser mayor que la cantidad total.');
            return;
        }
        if ($this->max_per_person !== null && $this->max_per_person > $this->quantity) {
            $this->addError('max_per_person', 'El máximo por persona no puede ser mayor que la cantidad total.');
            return;
        }
        if ($this->max_per_person !== null && $this->min_per_person !== null && $this->max_per_person < $this->min_per_person) {
            $this->addError('max_per_person', 'El máximo por persona no puede ser menor que el mínimo.');
            return;
        }

        $maxPerPerson = $this->allow_fractional && $this->max_per_person !== '' ? $this->max_per_person : null;
        $minPerPerson = $this->allow_fractional && $this->min_per_person !== '' ? $this->min_per_person : null;

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
                'max_per_person' => $maxPerPerson,
                'min_per_person' => $minPerPerson,
                'address_id' => $this->address_id, // <-- Añadido
            ]);
        } else {
            $product = Product::create([
                'name' => $this->name,
                'description' => $this->description,
                'quantity' => $this->quantity,
                'quantity_type' => $this->quantity_type,
                'price' => $this->price,
                'status' => $this->status ? 'activo' : 'inactivo',
                'user_id' => auth()->user() ? auth()->user()->id : null,
                'category_id' => $this->category_id,
                'allow_fractional' => $this->allow_fractional,
                'max_per_person' => $maxPerPerson,
                'min_per_person' => $minPerPerson,
                'address_id' => $this->address_id, // <-- Añadido
            ]);
            $this->productId = $product->id;
        }

        // Borrar imágenes marcadas
        if (!empty($this->imagesToDelete)) {
            foreach ($this->imagesToDelete as $imagePath) {
                $fullPath = 'model_images/' . $imagePath;
                if (Storage::disk('local')->exists($fullPath)) {
                    Storage::disk('local')->delete($fullPath);
                }
                $product->images()->where('path', $imagePath)->delete();
            }
            $this->imagesToDelete = [];
        }

        $order = 0;
        foreach ($this->images as $image) {
            if (is_object($image)) {

                $path = $image->store('model_images', 'local');
                $filename = basename($path);
                $product->images()->create([
                    'path' => $filename, // Solo el nombre
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

        return redirect()->route('private.profile');
    }

    public function delete()
    {
        if ($this->productId) {
            $product = Product::findOrFail($this->productId);
            foreach ($product->images as $img) {
                $fullPath = 'model_images/' . $img->path;
                if (Storage::disk('local')->exists($fullPath)) {
                    Storage::disk('local')->delete($fullPath);
                }
            }
            $product->images()->delete();
            $product->delete();
        }
        return redirect()->route('private.profile');
    }

    public function render()
    {
        return view('livewire.product.crud')->layout('layouts.app');
    }
}
