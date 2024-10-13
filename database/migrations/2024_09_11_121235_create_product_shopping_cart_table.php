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
        Schema::create('product_shopping_cart_tbl', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products_tbl')->onDelete('cascade');
            $table->foreignId('shopping_cart_id')->constrained('shopping_carts_tbl')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_shopping_card_tbl');
    }
};
