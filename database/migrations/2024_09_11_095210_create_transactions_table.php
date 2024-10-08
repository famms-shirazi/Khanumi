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
        Schema::create('transactions_tbl', function (Blueprint $table) {

            $table->id();

            $table->enum('status', ['successful','unsuccessful','paying']);
            $table->enum('type_id', ['deposit','withdrawal']);
            $table->string('transaction_unique_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
