<?php

namespace App\Livewire\Product;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Show extends Component
{
    public Product $product;
    public $quantity = 1;
    public $relatedProducts = [];

    // Para compra directa
    public $address_id;
    public $payment_method_id;

    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);

        $this->relatedProducts = Product::where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->where('status', 'activo')
            ->latest()
            ->take(4)
            ->get();

        $this->resetQuantity();

        if (auth()->check()) {
            $this->address_id = auth()->user()->addresses()->first()?->id;
            $this->payment_method_id = auth()->user()->paymentMethods()->first()?->id;
        }
    }

    public function resetQuantity()
    {
        if (!$this->product->allow_fractional) {
            $this->quantity = $this->product->quantity;
        } else {
            $this->quantity = max(
                (int) ($this->product->min_per_person ?? 1),
                1
            );
        }
    }

    public function updatedQuantity($value)
    {
        if (!$this->product->allow_fractional) {
            $this->quantity = $this->product->quantity;
        } else {
            $min = (int) ($this->product->min_per_person ?? 1);
            $maxRaw = $this->product->max_per_person ?? $this->product->quantity;
            $max = ((int)$maxRaw === 0) ? $this->product->quantity : (int)$maxRaw;

            $cleaned = intval($value);
            $this->quantity = max($min, min($max, $cleaned));
        }
    }

    public function addToCart()
    {
        if ($this->product->status === 'vendido') {
            session()->flash('error', 'Este producto ya ha sido vendido.');
            return;
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$this->product->id])) {
            session()->flash('error', 'Ya añadiste este producto al carrito.');
            return;
        }

        $cart[$this->product->id] = [
            'product_id' => $this->product->id,
            'name' => $this->product->name,
            'price' => $this->product->price,
            'quantity' => 1,
        ];

        session()->put('cart', $cart);
    }

    public function buyNow()
    {
        if ($this->product->status === 'vendido') {
            session()->flash('error', 'Este producto ya ha sido vendido.');
            return;
        }

        session()->put('buy_now', [
            'product_id' => $this->product->id,
            'quantity' => 1,
        ]);

        return redirect()->route(auth()->check() ? 'checkout.user' : 'checkout.guest');
    }


    // Lógica de compra directa
    public function processOrder($data)
    {
        DB::beginTransaction();
        try {
            // 1. Crear orden
            $order = Order::create([
                'user_id' => $data['user_id'] ?? null,
                'status' => 'pagado',
                'address_id' => $data['address_id'] ?? null,
                'payment_method_id' => $data['payment_method_id'] ?? null,
            ]);

            // 2. Duplicar producto vendido
            $sold = $this->product->replicate();
            $sold->status = 'vendido';
            $sold->save();

            // 3. Asignar a la orden
            OrderProduct::create([
                'order_id' => $order->id,
                'product_id' => $this->product->id,
                'product_sold_id' => $sold->id,
            ]);

            // 4. Crear pago
            Payment::create([
                'order_id' => $order->id,
                'payment_method_id' => $data['payment_method_id'] ?? null,
                'amount' => $this->product->price * $this->quantity,
                'status' => 'completado',
            ]);

            DB::commit();
            session()->forget('buy_now');
            return redirect()->route('checkout.success');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->addError('general', 'Error al procesar la orden: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.product.show')->layout('layouts.app');
    }
}
