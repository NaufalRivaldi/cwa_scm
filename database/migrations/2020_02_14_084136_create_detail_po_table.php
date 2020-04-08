<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_po', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('poId')->index();
            $table->unsignedBigInteger('barangId')->index();
            $table->integer('qty');
            $table->string('satuan');
            $table->double('disc');

            // fk
            $table->foreign('poId')
                    ->references('id')
                    ->on('po')
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
        Schema::dropIfExists('detail_po');
    }
}
