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

        // Permitir si el producto está activo o si el usuario es el dueño
        if ($product->status !== 'activo' && auth()->id() !== $product->user_id) {
            abort(403);
        }

        $filename = $image->path;
        $path = 'model_images/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        $file = Storage::disk('local')->get($path);
        $type = Storage::disk('local')->mimeType($path);

        return response($file, 200)->header('Content-Type', $type);
    }
}
