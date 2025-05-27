<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\PublicProfile;
use App\Livewire\PrivateProfile;
use App\Livewire\ShoppingCart;

use App\Http\Controllers\Auth\RegisterController;

use App\Livewire\Product\Index as ProductIndex;
use App\Livewire\Product\Show as ProductShow;
use App\Livewire\Product\Create as ProductCreate;
use App\Livewire\Product\Edit as ProductEdit;
use App\Livewire\Product\Delete as ProductDelete;


// Authentication Routes
Route::controller(RegisterController::class)->group(function () {
    Route::get('/custom-register', 'show')->name('custom.register');
    Route::post('/custom-register', 'store')->name('custom.register.store');
});

// Public Pages
Route::get('/', fn() => view('bancal.home'))->name('home');
Route::get('/contacto', fn() => view('bancal.contacto'))->name('contact');

// Account Management
Route::get('/perfil-privado', PrivateProfile::class)
    ->name('private-profile')
    ->middleware('auth');

// Product Routes
Route::prefix('productos')->group(function () {
    Route::get('/', ProductIndex::class)->name('products.index');
    Route::middleware('auth')->group(function () {
        Route::get('/crear', ProductCreate::class)->name('product.create');
        Route::get('/editar/{product}', ProductEdit::class)->name('product.edit');
        Route::get('/eliminar/{product}', [ProductDelete::class, 'deleteProduct'])->name('product.delete');
    });

    Route::get('/{product}', ProductShow::class)->name('product.show');
});

// Profile Route
Route::get('/perfil-publico/{user}', PublicProfile::class)->name('public.profile');

// Shopping Cart
Route::get('/carrito-de-la-compra', ShoppingCart::class)->name('shopping.cart');
