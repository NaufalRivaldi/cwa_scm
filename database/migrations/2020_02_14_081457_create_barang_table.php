<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kodeBarang', 25)->unique;
            $table->string('nama', 50);
            $table->enum('enum', [0,1]);
            $table->double('harga');
            $table->double('berat');
            $table->unsignedBigInteger('merkId');
            $table->unsignedBigInteger('supplierId');

            // fk
            $table->foreign('merkId')
                    ->references('id')
                    ->on('merk')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            
            $table->foreign('supplierId')
                    ->references('id')
                    ->on('supplier')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang');
    }
}
