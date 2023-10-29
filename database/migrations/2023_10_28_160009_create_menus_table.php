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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('restaurant_id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->integer('oPrice')->nullable();
            $table->integer('dPrice')->nullable();
            $table->string('image')->nullable();
            $table->enum('stock',['available','unavailable'])->default('available');// 0:Unavialible stock 1:Avialibale stock
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
