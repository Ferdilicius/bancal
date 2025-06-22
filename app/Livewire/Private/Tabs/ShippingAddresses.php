<?php

namespace App\Livewire\Private\Tabs;

use Livewire\Component;

class ShippingAddresses extends Component
{
	public function render()
	{
		$addresses = auth()->user()
			->addresses()
			->whereHas('addressType', function ($query) {
				$query->where('name', 'privado');
			})
			->get();

		return view('livewire.private.tabs.shipping-addresses', [
			'addresses' => $addresses,
		]);
	}

	public function delete($addressId)
	{
		$address = auth()->user()->addresses()->findOrFail($addressId);
		$address->delete();
		session()->flash('message', 'Dirección eliminada correctamente.');
	}
}
