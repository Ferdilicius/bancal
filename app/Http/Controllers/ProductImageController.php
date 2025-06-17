<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductImageController extends Controller
{
    public function show($productId, $imageId)
    {
        $product = Product::findOrFail($productId);
        $image = $product->images()->where('id', $imageId)->firstOrFail();

        $path = $image->path;

        if (!Storage::exists($path)) {
            abort(404);
        }

        // Permitir si el producto está activo o si el usuario es el dueño
        if ($product->status !== 'activo' && auth()->id() !== $product->user_id) {
            abort(403);
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return response($file, 200)->header('Content-Type', $type);
    }
}
