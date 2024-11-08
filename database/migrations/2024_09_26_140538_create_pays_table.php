<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaysTable extends Migration
{
    public function up()
    {
        Schema::create('pays', function (Blueprint $table) {
            $table->increments('pays_id');
            $table->string('pays_name');
            $table->string('pays_code', 10);
            $table->string('pays_zone')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pays');
    }
}
