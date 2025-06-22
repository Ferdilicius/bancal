<?php

namespace App\Livewire\Private\Tabs;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Address;

class Addresses extends Component
{
    public $addresses;

    public function mount()
    {
        $this->addresses = Auth::user()->addresses()
            ->whereHas('addressType', function ($q) {
                $q->where('name', '!=', 'privado');
            })
            ->get();
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

        $this->addresses = Auth::user()->addresses()
            ->whereHas('addressType', function ($q) {
                $q->where('name', '!=', 'privado');
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.private.tabs.addresses');
    }
}
