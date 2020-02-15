<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('kode', 10)->unique();
            $table->string('nama', 50);
            $table->enum('tax', [0,1]);
            $table->text('alamat');
            $table->string('telp', 50);
            $table->string('fax', 7);
            $table->string('email', 100);
            $table->integer('kredit');
            $table->string('pic', 25);
            $table->unsignedBigInteger('wilayahId');

            // fk
            $table->foreign('wilayahId')
                    ->references('id')
                    ->on('wilayah')
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
        Schema::dropIfExists('supplier');
    }
}
