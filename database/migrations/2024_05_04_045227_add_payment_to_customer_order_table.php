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
        Schema::table('customer_order', function (Blueprint $table) {
            $table->decimal('payment_usd', 10, 2)->nullable()->after('total');
            $table->decimal('payment_khr', 10, 2)->nullable()->after('payment_usd');
            $table->string('payment_method')->after('payment_khr');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_order', function (Blueprint $table) {
            $table->dropColumn('payment_usd');
            $table->dropColumn('payment_khr');
            $table->dropColumn('payment_method');
        });
    }
};
