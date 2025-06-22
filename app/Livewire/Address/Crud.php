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
    public $geometry = null;
    public $otherAddresses = [];

    public function mount($addressId = null)
    {
        // Ignora AddressType "privado"d
        $this->addressTypes = AddressType::where('name', '!=', 'privado')->get();
        $this->status = false;

        $privadoType = AddressType::where('name', 'privado')->first();

        if ($addressId) {
            $address = Address::with('images')->findOrFail($addressId);

            // No permitir cargar address con tipo "privado"
            if ($privadoType && $address->address_type_id == $privadoType->id) {
                abort(403);
            }

            $this->addressId = $addressId;
            $this->addressModel = $address;
            $this->name = $address->name;
            $this->address = $address->address;
            $this->latitude = $address->latitude;
            $this->longitude = $address->longitude;
            $this->status = $address->status === 'activo';
            $this->address_type_id = $address->address_type_id;
            $this->images = $address->images->pluck('path')->toArray();
            $this->geometry = $address->geometry ? json_encode($address->geometry) : null;
        }

        // Excluir addresses con tipo "privado" y la actual, solo con geometría
        $query = Address::where('user_id', auth()->id());
        if ($addressId) {
            $query->where('id', '!=', $addressId);
        }
        if ($privadoType) {
            $query->where('address_type_id', '!=', $privadoType->id);
        }
        $this->otherAddresses = $query->whereNotNull('geometry')->get(['geometry', 'name']);
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'images.*' => 'nullable',
            'newImages.*' => 'nullable|image|max:2048',
            'status' => 'required|boolean',
            'address_type_id' => 'required|exists:address_types,id',
            'geometry' => 'nullable|string',
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

        // Evitar guardar address con address_type "privado"
        $privadoType = AddressType::where('name', 'privado')->first();
        if ($privadoType && $this->address_type_id == $privadoType->id) {
            session()->flash('error', 'No se puede guardar una dirección con tipo "privado".');
            return;
        }

        if ($this->addressId) {
            $address = Address::findOrFail($this->addressId);
            $address->update([
                'name' => $this->name,
                'address' => $this->address,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'status' => $this->status ? 'activo' : 'inactivo',
                'address_type_id' => $this->address_type_id,
                'geometry' => $this->geometry ? json_decode($this->geometry, true) : null,
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
                'geometry' => $this->geometry ? json_decode($this->geometry, true) : null,
            ]);
            $this->addressId = $address->id;
        }

        // Borrar imágenes marcadas
        if (!empty($this->imagesToDelete)) {
            foreach ($this->imagesToDelete as $imagePath) {
                $fullPath = 'model_images/' . $imagePath;
                if (Storage::disk('local')->exists($fullPath)) {
                    Storage::disk('local')->delete($fullPath);
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
                $filename = basename($path);
                $address->images()->create([
                    'path' => $filename,
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

        return redirect()->route('private.profile');
    }

    public function delete()
    {
        if ($this->addressId) {
            $address = Address::findOrFail($this->addressId);
            foreach ($address->images as $img) {
                $fullPath = 'model_images/' . $img->path;
                if (Storage::disk('local')->exists($fullPath)) {
                    Storage::disk('local')->delete($fullPath);
                }
            }
            $address->images()->delete();
            $address->delete();
        }
        return redirect()->route('private.profile');
    }

    public function render()
    {
        return view('livewire.address.crud', [
            'otherAddresses' => $this->otherAddresses,
        ])->layout('layouts.app');
    }
}
