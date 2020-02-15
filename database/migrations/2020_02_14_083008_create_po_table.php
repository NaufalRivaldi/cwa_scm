<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nomer', 25)->unique;
            $table->date('tglPO');
            $table->date('tglPengiriman');
            $table->double('total');
            $table->double('ppn');
            $table->double('disc');
            $table->double('grandTotal');
            $table->enum('status', [1,2,3]);
            $table->unsignedBigInteger('userId');
            $table->unsignedBigInteger('cabangId');
            $table->unsignedBigInteger('supplierId');
            $table->timestamps();

            // fk
            $table->foreign('userId')
                    ->references('id')
                    ->on('user')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
                
            $table->foreign('cabangId')
                    ->references('id')
                    ->on('cabang')
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
        Schema::dropIfExists('po');
    }
}
