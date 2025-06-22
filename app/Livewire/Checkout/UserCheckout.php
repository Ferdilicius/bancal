<?php

namespace App\Livewire\Checkout;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Cart;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class UserCheckout extends Component
{
    public $payment_method_id;
    public $address_id;
    public $manual_address;
    public $manual_payment_method;

    public $cart = [];
    public $total = 0;

    public function mount()
    {
        // Compra directa (buy_now) o carrito
        if (session()->has('buy_now')) {
            $buyNow = session()->get('buy_now');
            $product = Product::findOrFail($buyNow['product_id']);
            $this->cart = [
                $product->id => [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $buyNow['quantity'],
                ]
            ];
        } else {
            // Carrito en DB
            if (auth()->check()) {
                $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
                $this->cart = [];
                foreach ($cart->products as $product) {
                    $this->cart[$product->id] = [
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $product->quantity,
                    ];
                }
            }
        }
        $this->calculateTotal();

        $this->address_id = auth()->user()->addresses()->first()?->id;
        $this->payment_method_id = auth()->user()->paymentMethods()->first()?->id;
    }

    public function calculateTotal()
    {
        $this->total = collect($this->cart)->sum(function ($item) {
            $product = Product::find($item['product_id']);
            if (!$product) return 0;

            return $product->allow_fractional
                ? $product->price // Si permite fraccionado, el precio es el base
                : $product->price * $item['quantity']; // Si no, se multiplica
        });
    }

    public function placeOrder()
    {
        $this->validate([
            'address_id' => 'nullable|exists:addresses,id',
            'manual_address' => 'required_without:address_id|string|max:255',
            'payment_method_id' => 'nullable|exists:payment_methods,id',
            'manual_payment_method' => 'required_without:payment_method_id|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            // 1. Crear orden
            $order = Order::create([
                'user_id' => auth()->id(),
                'status' => 'pagado',
                'address_id' => $this->address_id,
                'payment_method_id' => $this->payment_method_id,
            ]);

            // 2. Procesar productos
            foreach ($this->cart as $productId => $item) {
                $original = Product::findOrFail($productId);

                // Duplicar con estado 'vendido'
                $sold = $original->replicate();
                $sold->status = 'vendido';
                $sold->save();

                // Asignar a la orden
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'product_sold_id' => $sold->id,
                ]);
            }

            // 3. Crear pago
            Payment::create([
                'order_id' => $order->id,
                'payment_method_id' => $this->payment_method_id,
                'amount' => $this->total,
                'status' => 'completado',
            ]);

            DB::commit();

            // Limpiar carrito
            if (session()->has('buy_now')) {
                session()->forget('buy_now');
            } else {
                $cart = Cart::where('user_id', auth()->id())->first();
                if ($cart) $cart->items()->delete();
            }

            return redirect()->route('checkout.success');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('general', 'Error al procesar la orden: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.checkout.user-checkout')->layout('layouts.app');
    }
}
