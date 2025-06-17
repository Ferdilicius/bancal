<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ShoppingCart extends Component
{
	public $cart = [];
	protected $listeners = ['add-to-cart' => 'add'];

	public function mount()
	{
		$this->loadCart();
	}

	public function loadCart()
	{
		if (Auth::check()) {
			$order = Order::with('products')->firstOrCreate(
				['user_id' => Auth::id(), 'status' => 'pendiente']
			);

			$this->cart = ($order->products ?? collect())->map(function ($product) {
				return [
					'id' => $product->id,
					'name' => $product->name,
					'price' => $product->price,
					'quantity' => $product->pivot->quantity ?? 1,
				];
			})->toArray();
		} else {
			$sessionCart = session('cart', []);
			$this->cart = collect($sessionCart)->map(function ($qty, $productId) {
				$product = Product::find($productId);
				return [
					'id' => $product->id,
					'name' => $product->name,
					'price' => $product->price,
					'quantity' => $qty,
				];
			})->toArray();
		}
	}

	public function add($productId)
	{
		$product = Product::findOrFail($productId);

		if (Auth::check()) {
			$order = Order::firstOrCreate(
				['user_id' => Auth::id(), 'status' => 'pendiente']
			);

			$existing = $order->products()->where('product_id', $productId)->first();

			if ($existing) {
				$order->products()->updateExistingPivot($productId, [
					'quantity' => $existing->pivot->quantity + 1
				]);
			} else {
				$order->products()->attach($productId, ['quantity' => 1]);
			}
		} else {
			$cart = session()->get('cart', []);
			$cart[$productId] = ($cart[$productId] ?? 0) + 1;
			session()->put('cart', $cart);
		}

		$this->loadCart();
		$this->dispatch('cart-updated');
	}

	public function render()
	{
		return view('livewire.shopping-cart')->layout('layouts.app');
	}
}
