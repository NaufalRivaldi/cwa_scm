<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply', function (Blueprint $table) {
            $table->unsignedBigInteger('barangId')->index();
            $table->unsignedBigInteger('supplierId')->index();
            $table->double('harga');
            $table->double('diskon');
            $table->timestamps();

            // fk
            $table->foreign('barangId')
                    ->references('id')
                    ->on('barang')
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
        Schema::dropIfExists('supply');
    }
}
