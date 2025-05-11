<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;

use App\Livewire\Products;
use App\Livewire\ProductShow;

Route::get('/custom-register', [RegisterController::class, 'show'])->name('custom.register');
Route::post('/custom-register', [RegisterController::class, 'store'])->name('custom.register.store');

Route::get('/', function () {
    return view('bancal.index');
})->name('index');

Route::get('/contacto', function () {
    return view('bancal.contacto');
});

Route::prefix('productos')->group(function () {
    Route::get('/', Products::class)->name('products');
    Route::get('/{product}', ProductShow::class)->name('product.show');
});
