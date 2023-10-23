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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('oPrice')->nullable();
            $table->string('dPrice')->nullable();
            $table->string('image')->nullable();
            $table->string('stock')->default(1); // 0:Unavialible stock 1:Avialibale stock,
            $table->string('action')->nullable();
            $table->string('food_id')->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
