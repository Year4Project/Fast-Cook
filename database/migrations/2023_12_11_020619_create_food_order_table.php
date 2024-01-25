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
        // Check if the table does not exist before creating it
        if (!Schema::hasTable('food_order')) {
            Schema::create('food_order', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('food_id');
                $table->unsignedBigInteger('order_id');
                $table->integer('quantity');
                $table->timestamps();

                $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade');
                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the table if it exists
        Schema::dropIfExists('food_order');
    }
};
