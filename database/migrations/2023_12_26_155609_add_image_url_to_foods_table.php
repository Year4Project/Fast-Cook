<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageUrlToFoodsTable extends Migration
{
    public function up()
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->string('image_url')->nullable(); // You can adjust the data type if needed
        });
    }

    public function down()
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->dropColumn('image_url');
        });
    }
}
