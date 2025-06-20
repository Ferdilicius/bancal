<?php

namespace App\Livewire\Private\Tabs;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Address;

class Addresses extends Component
{
    public $addresses;
    public $selectedAddresses = [];

    public function mount()
    {
        $this->addresses = Auth::user()->addresses()->get();
    }

    public function deleteAddress($addressId)
    {
        $address = Address::findOrFail($addressId);

        foreach ($address->images as $img) {
            $fullPath = 'model_images/' . $img->path;
            if (Storage::disk('local')->exists($fullPath)) {
                Storage::disk('local')->delete($fullPath);
            }
        }
        $address->images()->delete();
        $address->delete();

        $this->addresses = Auth::user()->addresses()->get();
    }

    public function deleteMultipleAddresses()
    {
        $addresses = Address::whereIn('id', $this->selectedAddresses)->get();

        foreach ($addresses as $address) {
            foreach ($address->images as $img) {
                $fullPath = 'model_images/' . $img->path;
                if (Storage::disk('local')->exists($fullPath)) {
                    Storage::disk('local')->delete($fullPath);
                }
            }
            $address->images()->delete();
            $address->delete();
        }

        $this->selectedAddresses = [];

        $this->addresses = Auth::user()->addresses()->get();

        session()->flash('message', 'Direcciones eliminadas correctamente.');
    }

    public function updatedSelectedAddresses()
    {
        // Puedes agregar lógica si necesitas manejar "seleccionar todo"
    }

    public function duplicateAddress($id)
    {
        $original = Address::findOrFail($id);

        $copy = $original->replicate();
        $copy->name = $original->name . ' (Copia)';
        $copy->push();

        foreach ($original->images as $image) {
            $originalPath = 'model_images/' . $image->path;
            $extension = pathinfo($image->path, PATHINFO_EXTENSION);
            $newFilename = pathinfo($image->path, PATHINFO_FILENAME) . '_copy_' . uniqid() . '.' . $extension;
            $newPath = 'model_images/' . $newFilename;

            if (Storage::disk('local')->exists($originalPath)) {
                Storage::disk('local')->copy($originalPath, $newPath);
                $copy->images()->create(['path' => $newFilename]);
            }
        }

        $this->addresses = Auth::user()->addresses()->get();
    }

    public function render()
    {
        return view('livewire.private.tabs.addresses');
    }
}
