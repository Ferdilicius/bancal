<?php

namespace App\Livewire\Address;

use App\Models\Address;
use Livewire\Component;

class Show extends Component
{
	public $address;
	public $products = [];

	public function mount($addressId)
	{
		$this->address = Address::where('id', $addressId)
			->whereHas('addressType', function ($query) {
				$query->where('name', '!=', 'privado');
			})
			->where(function ($query) {
				$query->where('status', 'activo')
					->orWhere(function ($q) {
						$q->where('status', 'inactivo')
							->where('user_id', auth()->id());
					});
			})
			->first();

		if (!$this->address) {
			abort(404);
		}

		$this->products = $this->address->product()
			->where('status', 'activo')
			->latest()
			->take(8)
			->get();
	}

	public function render()
	{
		return view('livewire.address.show')->layout('layouts.app');
	}
}
