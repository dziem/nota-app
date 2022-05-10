<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestockDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restock_detail', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->integer('restock_id');

            $table->foreign('restock_id')
                ->references('id')
                ->on('restock');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restock_detail');
    }
}
