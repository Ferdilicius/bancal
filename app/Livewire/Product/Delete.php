<?php

namespace App\Livewire\Product;

use Livewire\Component;
use App\Models\Product;

use Illuminate\Support\Facades\Storage;

class Delete extends Component
{
    public function deleteProduct($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            // Delete product images from storage
            if ($product->images) {
                foreach ($product->images as $image) {
                    if (Storage::exists($image->path)) {
                        Storage::delete($image->path);
                    }
                }
            }
            $product->delete();
        }

        return redirect()->route('private-profile');
    }

    public function render()
    {
        return view('livewire.private-profile')->layout('layouts.app');
    }
}
