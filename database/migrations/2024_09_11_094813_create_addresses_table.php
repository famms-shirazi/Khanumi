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
        Schema::create('addresses_tbl', function (Blueprint $table) {
            $table->id();

            $table->string('address');
            $table->integer('postal_code');

            //relational fields
            $table->foreignId('user_id')->constrained('users_tbl')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities_tbl')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
