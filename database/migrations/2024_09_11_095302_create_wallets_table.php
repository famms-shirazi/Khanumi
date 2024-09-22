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
        Schema::create('wallets_tbl', function (Blueprint $table) {
            $table->id();
            $table->double('balance');
            $table->timestamps();

            //relational fields
            $table->foreignId('user_id')->constrained('users_tbl')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets_tbl');
    }
};
