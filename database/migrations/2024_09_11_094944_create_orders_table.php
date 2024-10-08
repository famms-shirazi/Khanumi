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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status_id',['current','sent','cancelled','delivered']);
            $table->integer('unique_id');

            //relational fields
            $table->foreignId('user_id')->constrained('users_tbl')->onDelete('cascade');
            $table->foreignId('order_details_id')->constrained('order_details_tbl')->onDelete('cascade');
            $table->foreignId('transaction_id')->constrained('transactions_tbl')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
