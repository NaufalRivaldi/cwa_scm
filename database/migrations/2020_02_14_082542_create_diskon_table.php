<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiskonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diskon', function (Blueprint $table) {
            $table->unsignedBigInteger('wilayahId')->index();
            $table->unsignedBigInteger('barangId')->index();
            $table->double('diskon');

            // fk
            $table->foreign('wilayahId')
                    ->references('id')
                    ->on('wilayah')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('barangId')
                    ->references('id')
                    ->on('barang')
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
        Schema::dropIfExists('diskon');
    }
}
