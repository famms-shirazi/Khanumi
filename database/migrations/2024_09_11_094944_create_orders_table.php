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
        Schema::create('orders_tbl', function (Blueprint $table) {
            $table->id();
            $table->enum('status',['current','sent','cancelled','delivered']);
            $table->bigInteger('order_code')->unique();
            $table->foreignId('user_id')->constrained('users_tbl')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_tbl');
    }
};
