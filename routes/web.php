<?php

use Illuminate\Support\Facades\Route;

use App\Http\Middleware\AdminMiddleware;

use App\Livewire\PublicProfile;
use App\Livewire\Private\PrivateProfile;

use App\Http\Controllers\Auth\RegisterController;

// Product
use App\Livewire\Product\Index as ProductIndex;
use App\Livewire\Product\Show as ProductShow;
use App\Livewire\Product\Crud as ProductCrud;

// Address
use App\Livewire\Address\Index as AddressIndex;
use App\Livewire\Address\Show as AddressShow;
use App\Livewire\Address\Crud as AddressCrud;

// Cart
use App\Livewire\Cart\Show as ShowCart;

// Checkout
use App\Livewire\Checkout\UserCheckout;
use App\Livewire\Checkout\GuestCheckout;

// Order Success
use App\Livewire\Order\Success as OrderSuccess;

// Address Shipping
use App\Livewire\AddressShip\Crud as AddressShipCrud;

// Product Image
use App\Http\Controllers\ProductImageController;

// Address Image
use App\Http\Controllers\AddressImageController;

// Admin
use App\Livewire\Admin\Crud as AdminCrud;

// Contact
use App\Livewire\Contact\Contact as ContactPage;

// Socialite
use App\Http\Controllers\SocialiteController;

use App\Livewire\PaymentMethod\Crud as PaymentMethodCrud;

// Authentication Routes
Route::controller(RegisterController::class)->group(function () {
    Route::get('/custom-register', 'show')->name('custom.register');
    Route::post('/custom-register', 'store')->name('custom.register.store');
});

// Public Pages
Route::get('/', fn() => view('bancal.home'))->name('home');
Route::get('/contacto', ContactPage::class)->name('contact');

// Account Management
Route::middleware('auth')->get('/perfil-privado', PrivateProfile::class)->name('private.profile');

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
    });

    Route::get('/{addressId}', AddressShow::class)->name('address.show');
    Route::get('/{addressId}/{imageId}', [AddressImageController::class, 'show'])->name('address.image');
});

// Payment Methods Routes
Route::prefix('metodos-de-pago')->middleware('auth')->group(function () {
    Route::get('/crear', PaymentMethodCrud::class)->name('payment_method.create');
    Route::get('/editar/{paymentMethodId}', PaymentMethodCrud::class)->name('payment_method.edit');
});

// Address Shipping Routes
Route::prefix('direcciones-envio')->middleware('auth')->group(function () {
    Route::get('/crear', AddressShipCrud::class)->name('shipping_address.create');
    Route::get('/editar/{addressId}', AddressShipCrud::class)->name('shipping_address.edit');
});

// Cart/Order Routes
Route::get('/carrito', ShowCart::class)->name('cart.show');

Route::get('/checkout', function () {
    return redirect(auth()->check() ? route('checkout.user') : route('checkout.guest'));
})->name('checkout');

Route::get('/checkout/usuario', UserCheckout::class)->middleware('auth')->name('checkout.user');
Route::get('/checkout/invitado', GuestCheckout::class)->name('checkout.guest');

Route::get('/pedido/confirmado', OrderSuccess::class)->name('checkout.success');

// Profile Route
Route::get('/perfil-publico/{user}', PublicProfile::class)->name('public.profile');

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])->get('/admin', AdminCrud::class)->name('admin.index');

// Socialite Authentication
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');

Route::get('/profile-photo/{filename}', function ($filename) {
    $path = storage_path('app/private/profile-photos/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('profile.photo');
