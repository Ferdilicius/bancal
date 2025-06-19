<?php

namespace App\Livewire\Address;

use App\Models\Address;
use Livewire\Component;

class Show extends Component
{
	public $address;

	public function mount($addressId)
	{
		$this->address = Address::where('id', $addressId)
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
	}

	public function render()
	{
		return view('livewire.address.show')->layout('layouts.app');
	}
}
