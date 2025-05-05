<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Index;
use App\Livewire\Products;

Route::get('/', Index::class)->name('index');

// Route::get('contacto', function () {
//     return view('contacto');
// })->name('contacto');
