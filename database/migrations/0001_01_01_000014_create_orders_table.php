<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pendiente', 'pagado', 'cancelado'])->default('pendiente');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('address_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('payment_method_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
