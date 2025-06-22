<?php

namespace App\Livewire\AddressShip;

use Livewire\Component;
use App\Models\Address;
use App\Models\AddressType;

class Crud extends Component
{
	public $addressId;
	public $name;
	public $address;
	public $latitude;
	public $longitude;
	public $geometry;
	public $otherAddresses; // Añadido

	public function mount($addressId = null)
	{
		$this->addressId = $addressId;

		// Si es edición, verifica que la dirección sea de tipo 'privado'
		if ($addressId) {
			$address = Address::find($addressId);
			if ($address) {
				// Verifica que el tipo de dirección sea 'privado'
				if ($address->addressType && $address->addressType->name !== 'privado') {
					abort(403, 'No autorizado para editar esta dirección.');
				}
				$this->name = $address->name;
				$this->address = $address->address;
				$this->latitude = $address->latitude;
				$this->longitude = $address->longitude;
				$this->geometry = $address->geometry;
			}
		}

		$this->otherAddresses = Address::whereHas('addressType', function ($query) {
			$query->where('name', 'privado');
		})
			->where('user_id', auth()->id())
			->when($addressId, function ($query) use ($addressId) {
				return $query->where('id', '!=', $addressId);
			})
			->get();
	}

	public function save()
	{
		$this->validate([
			'name' => 'required|string|max:255',
			'address' => 'required|string|max:255',
			'latitude' => 'required|numeric',
			'longitude' => 'required|numeric',
			'geometry' => 'required|string',
		], [
			'latitude.required' => 'Debes seleccionar la ubicación en el mapa.',
			'longitude.required' => 'Debes seleccionar la ubicación en el mapa.',
			'geometry.required' => 'Debes seleccionar la ubicación en el mapa.',
		]);

		if ($this->addressId) {
			$address = Address::findOrFail($this->addressId);
			// Verifica que el tipo de dirección sea 'privado'
			if ($address->addressType && $address->addressType->name !== 'privado') {
				abort(403, 'No autorizado para editar esta dirección.');
			}
		} else {
			$address = new Address();
			$address->user_id = auth()->id();
			$address->address_type_id = AddressType::where('name', 'privado')->value('id');
		}

		$address->name = $this->name;
		$address->address = $this->address;
		$address->latitude = $this->latitude;
		$address->longitude = $this->longitude;
		$address->geometry = $this->geometry;
		$address->save();

		session()->flash('success', $this->addressId ? 'Dirección actualizada.' : 'Dirección creada.');
		return redirect()->route('private.profile');
	}

	public function delete()
	{
		if ($this->addressId) {
			$address = Address::findOrFail($this->addressId);
			// Verifica que el tipo de dirección sea 'privado'
			if ($address->addressType && $address->addressType->name !== 'privado') {
				abort(403);
			}
			$address->delete();
			session()->flash('success', 'Dirección eliminada.');
		}
		return redirect()->route('private.profile');
	}

	public function render()
	{
		return view('livewire.address-ship.crud')
			->layout('layouts.app');
	}
}
