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
        Schema::create('order_details_tbl', function (Blueprint $table) {

            $table->id();

            $table->string('tracking_code');
            $table->string('delivery_recipient');
            $table->float('profit');
            $table->enum('payment_type',['online', 'cash']);
            $table->float('shipping_cost');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
