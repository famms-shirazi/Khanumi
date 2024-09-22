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
        Schema::create('files_tbl', function (Blueprint $table) {
            $table->id();

            $table->string('url');
            $table->integer('fileable_id');
            $table->string('fileable_type');

            //relational fields
            $table->foreignId('user_id')->constrained('users_tbl')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
