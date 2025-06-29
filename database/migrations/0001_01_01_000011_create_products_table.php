<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->float('quantity')->default(0);
            $table->float('price');
            $table->enum('status', ['inactivo', 'activo', 'vendido'])->default('inactivo');
            $table->enum('quantity_type', ['gramo', 'kilo', 'unidad', 'litro', 'bolsa', 'caja'])->default('unidad');
            $table->boolean('allow_fractional')->default(false);
            $table->float('min_per_person')->nullable();
            $table->float('max_per_person')->nullable();
            $table->foreignId('address_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained('product_categories')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
