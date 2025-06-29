<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Address;

class AddressImageController extends Controller
{
    public function show($addressId, $imageId)
    {
        $address = Address::findOrFail($addressId);
        $image = $address->images()->where('id', $imageId)->firstOrFail();

        $path = 'model_images/' . $image->path;

        if (!Storage::exists($path)) {
            abort(404);
        }

        if ($address->status !== 'activo' && auth()->id() !== $address->user_id) {
            abort(403);
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return response($file, 200)->header('Content-Type', $type);
    }
}
