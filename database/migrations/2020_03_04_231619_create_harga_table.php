<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga', function (Blueprint $table) {
            $table->unsignedBigInteger('barangId')->index();
            $table->unsignedBigInteger('wilayahId')->index();
            $table->double('harga');
            $table->timestamps();

            // fk
            $table->foreign('barangId')
                    ->references('id')
                    ->on('barang')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');

            $table->foreign('wilayahId')
                    ->references('id')
                    ->on('wilayah')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        // drop column harga
        Schema::table('barang', function(Blueprint $table){
            $table->dropColumn('harga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('harga');
    }
}
