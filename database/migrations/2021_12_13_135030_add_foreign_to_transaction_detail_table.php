<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignToTransactionDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_detail', function (Blueprint $table) {
            $table->foreign('transaction_id')
                ->references('id')
                ->on('transaction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_detail', function (Blueprint $table) {
            $table->dropForeign(['transaction_id']);
        });
    }
}
