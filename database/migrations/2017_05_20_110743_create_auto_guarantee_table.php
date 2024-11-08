<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoGuaranteeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_guarantee', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codeguar',10);
            $table->string('titleguar',100);
            $table->text('description');
            $table->integer('isdeprecated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_guarantee');
    }
}
