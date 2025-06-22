<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pendiente', 'completado', 'fallido'])->default('pendiente');
            $table->decimal('amount', 10, 2);
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
