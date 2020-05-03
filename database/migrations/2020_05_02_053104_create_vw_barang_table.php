<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVwBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vw_barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('order');
            $table->unsignedBigInteger('barangId');
            
            $table->foreign('barangId')
                    ->references('id')
                    ->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vw_barang');
    }
}
