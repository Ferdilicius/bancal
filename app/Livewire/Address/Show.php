<?php

namespace App\Livewire\Address;

use App\Models\Address;
use Livewire\Component;

class Show extends Component
{
	public $address;

	public function mount($addressId)
	{
		$this->address = Address::find($addressId);
	}

	public function render()
	{
		return view('livewire.address.show')->layout('layouts.app');
	}
}
