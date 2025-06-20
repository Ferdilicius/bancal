<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
<<<<<<< HEAD
            $table->string('email')->nullable();
            $table->string('message');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('message_type_id')->nullable()->constrained('message_types')->onDelete('cascade');
=======
            $table->string('email');
            $table->string('content');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('message_type_id')->constrained('message_types')->onDelete('cascade');
>>>>>>> 1981173d980d52139ff4b7700415768a27a72488
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
