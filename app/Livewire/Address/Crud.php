<?php

namespace App\Livewire\Address;

use Livewire\Component;
use App\Models\Address;
use App\Models\AddressType;
use Illuminate\Support\Facades\Auth;

class Crud extends Component
{
    public $address_id;
    public $address;
    public $name;
    public $image;
    public $status = 'inactivo';
    public $user_id;
    public $address_type_id;

    protected $rules = [
        'address' => 'required|string|unique:addresses,address',
        'name' => 'nullable|string',
        'image' => 'nullable|string',
        'status' => 'required|in:inactivo,activo',
        'address_type_id' => 'required|exists:address_types,id',
    ];

    public function mount($addressId = null)
    {
        $this->user_id = Auth::id();
        if ($addressId) {
            $address = Address::findOrFail($addressId);
            $this->address_id = $address->id;
            $this->address = $address->address;
            $this->name = $address->name;
            $this->image = $address->image;
            $this->status = $address->status;
            $this->address_type_id = $address->address_type_id;
        }
    }

    public function save()
    {
        $rules = $this->rules;
        if ($this->address_id) {
            $rules['address'] .= ',' . $this->address_id;
        }
        $this->validate($rules);

        Address::updateOrCreate(
            ['id' => $this->address_id],
            [
                'address' => $this->address,
                'name' => $this->name,
                'image' => $this->image,
                'status' => $this->status,
                'user_id' => $this->user_id,
                'address_type_id' => $this->address_type_id,
            ]
        );

        session()->flash('message', $this->address_id ? 'Dirección actualizada.' : 'Dirección creada.');
        $this->resetExcept('user_id');
    }

    public function edit($addressId)
    {
        $address = Address::findOrFail($addressId);
        $this->address_id = $address->id;
        $this->address = $address->address;
        $this->name = $address->name;
        $this->image = $address->image;
        $this->status = $address->status;
        $this->address_type_id = $address->address_type_id;
    }

    public function delete($addressId)
    {
        $address = Address::findOrFail($addressId);
        $address->delete();
        session()->flash('message', 'Dirección eliminada.');
        $this->resetExcept('user_id');
    }

    public function render()
    {
        $addresses = Address::where('user_id', $this->user_id)->get();
        $addressTypes = AddressType::all();

        return view('livewire.address.save', compact('addresses', 'addressTypes'))->layout('layouts.app');
    }
}
