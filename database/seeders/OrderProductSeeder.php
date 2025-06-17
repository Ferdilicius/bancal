<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;

class OrderProductSeeder extends Seeder
{
    public function run()
    {
        $orders = Order::all();
        $productIds = Product::pluck('id')->toArray();

        foreach ($orders as $order) {
            $randomProductIds = collect($productIds)->random(2);

            foreach ($randomProductIds as $productId) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                ]);

                $product = Product::find($productId);
                if ($product) {
                    $product->status = 'inactivo';
                    $product->save();
                }
            }
        }
    }
}
