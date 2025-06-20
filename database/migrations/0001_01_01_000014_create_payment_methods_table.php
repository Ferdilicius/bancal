<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('type'); // tarjeta, paypal, bizum, etc.
            $table->string('provider')->nullable(); // Visa, MasterCard, PayPal, etc.
            $table->string('account_name')->nullable(); // Nombre en tarjeta o cuenta
            $table->string('account_number')->nullable(); // Últimos 4 dígitos, IBAN o email
            $table->string('expiration')->nullable(); // MM/YY o fecha de expiración
            $table->boolean('is_default')->default(false); // Método principal

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
