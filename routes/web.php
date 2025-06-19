<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\PublicProfile;
use App\Livewire\Private\PrivateProfile;
use App\Livewire\ShoppingCart;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Auth\RegisterController;

// Product
use App\Livewire\Product\Index as ProductIndex;
use App\Livewire\Product\Show as ProductShow;
use App\Livewire\Product\Crud as ProductCrud;

// Product Image
use App\Http\Controllers\ProductImageController;

// Address Image
use App\Http\Controllers\AddressImageController;

// Address
use App\Livewire\Address\Index as AddressIndex;
use App\Livewire\Address\Show as AddressShow;
use App\Livewire\Address\Crud as AddressCrud;

// Purchase
use App\Livewire\Purchase\Crud as PurchaseCrud;

// Sale
use App\Livewire\Sale\Crud as SaleCrud;

// Authentication Routes
Route::controller(RegisterController::class)->group(function () {
    Route::get('/custom-register', 'show')->name('custom.register');
    Route::post('/custom-register', 'store')->name('custom.register.store');
});

// Public Pages
Route::get('/', fn() => view('bancal.home'))->name('home');
Route::get('/contacto', fn() => view('bancal.contacto'))->name('contact');

// Account Management
Route::middleware('auth')->get('/perfil-privado', PrivateProfile::class)->name('private-profile');

// Product Routes
Route::prefix('productos')->group(function () {

    Route::get('/', ProductIndex::class)->name('product.index');

    Route::middleware('auth')->group(function () {
        Route::get('/crear', ProductCrud::class)->name('product.create');
        Route::get('/editar/{productId}', ProductCrud::class)->name('product.edit');
    });
    Route::get('/{productId}', ProductShow::class)->name('product.show');

    Route::get('/{productId}/{imageId}', [ProductImageController::class, 'show'])->name('product.image');
});

// Address Routes
Route::prefix('bancales')->group(function () {

    Route::get('/', AddressIndex::class)->name('address.index');

    Route::middleware('auth')->group(function () {
        Route::get('/crear', AddressCrud::class)->name('address.create');
        Route::get('/editar/{addressId}', AddressCrud::class)->name('address.edit');
        Route::delete('/eliminar/{addressId}', AddressCrud::class)->name('address.delete');
    });

    Route::get('/{addressId}', AddressShow::class)->name('address.show');

    Route::get('/{addressId}/{imageId}', [AddressImageController::class, 'show'])->name('address.image');
});

// Purchase Routes
Route::prefix('compras')->middleware('auth')->group(function () {
    Route::get('/crear', PurchaseCrud::class)->name('purchase.create');
    Route::get('/editar/{purchase}', PurchaseCrud::class)->name('purchase.edit');
    Route::get('/eliminar/{purchase}', [PurchaseCrud::class, 'deletePurchase'])->name('purchase.delete');
});

// Sale Routes
Route::prefix('ventas')->middleware('auth')->group(function () {
    Route::get('/crear', SaleCrud::class)->name('sale.create');
    Route::get('/editar/{sale}', SaleCrud::class)->name('sale.edit');
    Route::get('/eliminar/{sale}', [SaleCrud::class, 'deleteSale'])->name('sale.delete');
});

// Profile Route
Route::get('/perfil-publico/{user}', PublicProfile::class)->name('public.profile');

// Shopping Cart
Route::get('/carrito-de-la-compra', ShoppingCart::class)->name('shopping-cart.index');

// Fallback Route
use App\Http\Controllers\SocialiteController;

Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');

Route::get('/profile-photo/{filename}', function ($filename) {
    $path = storage_path('app/private/profile-photos/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->middleware('auth')->name('profile.photo');