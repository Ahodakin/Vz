<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoReglementarycostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_reglementarycost', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('placecost');
            $table->float('autotaux');
            $table->double('fga');
            $table->text('drecours');
            $table->text('ranticipe');
            $table->text('rcivile');
            $table->double('default_redcom');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_reglementarycost');
    }
}
