<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('base_price')->nullable();
            $table->integer('stock')->nullable();
            $table->integer('price_id');

            $table->foreign('price_id')
                ->references('id')
                ->on('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_detail');
    }
}
