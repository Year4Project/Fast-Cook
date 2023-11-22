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
            $table->bigInteger('restaurant_id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->integer('oPrice')->nullable();
            $table->integer('dPrice')->nullable();
            $table->text('description');
            $table->string('image')->nullable();
            $table->integer('status')->default(1); // 0 Unavailable , 1 Available
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
