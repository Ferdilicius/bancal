<?php

namespace App\Livewire\Cart;

use Livewire\Component;
use App\Models\Product;

class Show extends Component
{
    public $cart = [];
    public $total = 0;

    public function mount()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateTotal();
    }

    public function increase($productId)
    {
        if (isset($this->cart[$productId])) {
            $product = Product::find($productId);
            if (!$product || $product->status === 'vendido') {
                $this->addError('general', 'Este producto ya no está disponible.');
                return;
            }

            if ($this->cart[$productId]['quantity'] >= 1) {
                $this->addError('general', 'Solo puedes comprar una unidad de este producto.');
                return;
            }

            $this->cart[$productId]['quantity'] += 1;
            $this->updateSession();
        }
    }


    public function decrease($productId)
    {
        if (isset($this->cart[$productId])) {
            $this->cart[$productId]['quantity'] -= 1;
            if ($this->cart[$productId]['quantity'] <= 0) {
                unset($this->cart[$productId]);
            }
            $this->updateSession();
        }
    }

    public function remove($productId)
    {
        unset($this->cart[$productId]);
        $this->updateSession();
    }

    public function updateSession()
    {
        session()->put('cart', $this->cart);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function proceedToCheckout()
    {
        return redirect()->route(auth()->check() ? 'checkout.user' : 'checkout.guest');
    }

    public function render()
    {
        return view('livewire.cart.show')->layout('layouts.app');
    }
}
