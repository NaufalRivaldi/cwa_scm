<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerusahaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perusahaan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama', 50);
            $table->text('alamat');
            $table->string('telp', 50);
            $table->string('fax', 7);
            $table->string('email', 100);
            $table->string('pic', 50);
            $table->binary('logo');
            $table->binary('cap');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perusahaan');
    }
}
