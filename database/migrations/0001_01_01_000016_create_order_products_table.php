<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up()
	{
		Schema::create('order_products', function (Blueprint $table) {
			$table->id();
			$table->foreignId('order_id')->constrained()->onDelete('cascade');
			$table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
			$table->foreignId('product_sold_id')->constrained('products')->onDelete('cascade');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('order_products');
	}
};
