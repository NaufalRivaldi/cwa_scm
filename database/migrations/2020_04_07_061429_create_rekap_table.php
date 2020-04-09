<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('trd')->nullable();
            $table->date('tdo')->nullable();
            $table->date('td')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('detailPoId');
            $table->timestamps();

            // fk
            $table->foreign('detailPoId')
                    ->references('id')
                    ->on('detail_po')
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
        Schema::dropIfExists('rekap');
    }
}
