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

            $table->dateTime('order_submission_date_time');
            $table->dateTime('order_delivery_date_time');
            $table->string('recipient');
            $table->enum('payment_type', ['cash', 'online']);
            $table->double('shipping_cost');
            $table->double('final_cost');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
