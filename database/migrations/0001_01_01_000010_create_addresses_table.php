<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('address')->unique();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['inactivo', 'activo'])->default('inactivo');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('address_type_id')->constrained('address_types')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
