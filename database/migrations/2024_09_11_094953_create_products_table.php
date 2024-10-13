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
        Schema::create('products_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('persian_title');
            $table->string('english_title');
            $table->string('slug');
            $table->double('product_size');
            $table->double('price');
            $table->text('product_introduction_text');
            $table->text('consumption_guide_text');
            $table->integer('inventory');
            $table->foreignId('brand_id')->constrained('brands_tbl')->onDelete('cascade');
            $table->foreignId('special_offer_id')->constrained('special_offers_tbl')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
