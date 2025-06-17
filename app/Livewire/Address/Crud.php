<?php

namespace App\Livewire\Address;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Address;
use App\Models\AddressType;
use Illuminate\Support\Facades\Storage;

class Crud extends Component
{
    use WithFileUploads;

    public $addressId;
    public $name;
    public $address;
    public $latitude;
    public $longitude;
    public $images = [];
    public $newImages = [];
    public $imagesToDelete = [];
    public $status;
    public $address_type_id;
    public $addressTypes;
    public $addressModel;

    public function mount($addressId = null)
    {
        $this->addressTypes = AddressType::all();
        $this->status = false;

        if ($addressId) {
            $this->addressId = $addressId;
            $this->addressModel = Address::with('images')->findOrFail($addressId);
            $this->name = $this->addressModel->name;
            $this->address = $this->addressModel->address;
            $this->latitude = $this->addressModel->latitude;
            $this->longitude = $this->addressModel->longitude;
            $this->status = $this->addressModel->status === 'activo';
            $this->address_type_id = $this->addressModel->address_type_id;
            $this->images = $this->addressModel->images->pluck('path')->toArray();
        }
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'images.*' => 'nullable',
            'newImages.*' => 'nullable|image|max:2048',
            'status' => 'required|boolean',
            'address_type_id' => 'required|exists:address_types,id',
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
            if (is_string($image) && $this->addressId) {
                $this->imagesToDelete[] = $image;
            }
            unset($this->images[$index]);
            $this->images = array_values($this->images);
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->addressId) {
            $address = Address::findOrFail($this->addressId);
            $address->update([
                'name' => $this->name,
                'address' => $this->address,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'status' => $this->status ? 'activo' : 'inactivo',
                'address_type_id' => $this->address_type_id,
            ]);
        } else {
            $address = Address::create([
                'name' => $this->name,
                'address' => $this->address,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'status' => $this->status ? 'activo' : 'inactivo',
                'user_id' => auth()->user() ? auth()->user()->id : null,
                'address_type_id' => $this->address_type_id,
            ]);
            $this->addressId = $address->id;
        }

        // Borrar imágenes marcadas
        if (!empty($this->imagesToDelete)) {
            foreach ($this->imagesToDelete as $imagePath) {
                if (Storage::disk('local')->exists($imagePath)) {
                    Storage::disk('local')->delete($imagePath);
                }
                $address->images()->where('path', $imagePath)->delete();
            }
            $this->imagesToDelete = [];
        }

        // Guardar imágenes nuevas y actualizar orden
        $order = 0;
        foreach ($this->images as $image) {
            if (is_object($image)) {
                $path = $image->store('model_images', 'local');
                $address->images()->create([
                    'path' => $path,
                    'order' => $order++,
                ]);
            } elseif (is_string($image)) {
                $img = $address->images()->where('path', $image)->first();
                if ($img) {
                    $img->order = $order++;
                    $img->save();
                }
            }
        }

        return redirect()->route('private-profile');
    }

    public function delete()
    {
        if ($this->addressId) {
            $address = Address::findOrFail($this->addressId);
            foreach ($address->images as $img) {
                if (Storage::disk('local')->exists($img->path)) {
                    Storage::disk('local')->delete($img->path);
                }
            }
            $address->images()->delete();
            $address->delete();
        }
        return redirect()->route('private-profile');
    }

    public function render()
    {
        return view('livewire.address.crud')->layout('layouts.app');
    }
}