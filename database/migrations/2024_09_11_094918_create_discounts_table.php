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
        Schema::create('discounts_tbl', function (Blueprint $table) {

            $table->id();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->enum('code_type',['percent','shopping_cart','product'])->default('percent');
            $table->enum('amount_type',['percent','money'])->default('percent');
            $table->integer('amount');
            $table->dateTime('expiration_date_time')->nullable();
            $table->integer('counter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts_tbl');
    }
};
