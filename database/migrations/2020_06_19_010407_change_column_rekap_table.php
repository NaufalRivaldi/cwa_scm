<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnRekapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekap', function(Blueprint $table){
            $table->dropColumn(['trd', 'tdo', 'td']);
            $table->date('tglDatang')->after('id');            
        });

        Schema::table('rekap', function(Blueprint $table){
            $table->integer('qty')->default('0')->after('tglDatang');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
