<?php

namespace App\Livewire\Checkout;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Address;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class GuestCheckout extends Component
{
	public $name;
	public $email;
	public $phone;

	public $street;
	public $city;
	public $zip;
	public $country;

	public $payment_type;
	public $payment_details;

	public $cart = [];
	public $total = 0;

	public function mount()
	{
		$this->cart = session()->get('cart', []);
		$this->calculateTotal();
	}

	public function calculateTotal()
	{
		$this->total = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
	}

	public function placeOrder()
	{
		$this->validate([
			'name' => 'required|string|min:2',
			'email' => 'required|email',
			'phone' => 'nullable|string',

			'street' => 'required|string',
			'city' => 'required|string',
			'zip' => 'required|string',
			'country' => 'required|string',

			'payment_type' => 'required|in:card,paypal,bizum,other',
			'payment_details' => 'nullable|string',
		]);

		DB::beginTransaction();

		try {
			// 1. Crear dirección
			$address = Address::create([
				'name' => $this->name,
				'email' => $this->email,
				'phone' => $this->phone,
				'street' => $this->street,
				'city' => $this->city,
				'zip' => $this->zip,
				'country' => $this->country,
			]);

			// 2. Método de pago anónimo
			$paymentMethod = PaymentMethod::create([
				'name' => $this->name,
				'type' => $this->payment_type,
				'details' => $this->payment_details,
				'status' => 'active',
				'user_id' => null,
			]);

			// 3. Crear orden
			$order = Order::create([
				'user_id' => null,
				'status' => 'pagado',
				'address_id' => $address->id,
				'payment_method_id' => $paymentMethod->id,
			]);

			// 4. Procesar productos
			foreach ($this->cart as $productId => $item) {
				$original = Product::findOrFail($productId);

				$sold = $original->replicate();
				$sold->status = 'vendido';
				$sold->save();

				OrderProduct::create([
					'order_id' => $order->id,
					'product_id' => $productId,
					'product_sold_id' => $sold->id,
				]);
			}

			// 5. Crear pago
			Payment::create([
				'order_id' => $order->id,
				'payment_method_id' => $paymentMethod->id,
				'amount' => $this->total,
				'status' => 'completado',
			]);

			DB::commit();

			session()->forget('cart');
			return redirect()->route('checkout.success');
		} catch (\Exception $e) {
			DB::rollBack();
			$this->addError('general', 'Error al procesar la orden: ' . $e->getMessage());
		}
	}

	public function render()
	{
		return view('livewire.checkout.guest-checkout')->layout('layouts.app');
	}
}
