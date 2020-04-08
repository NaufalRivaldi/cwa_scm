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
            $table->date('trd');
            $table->date('tdo');
            $table->date('td');
            $table->text('keterangan');
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
