<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarTypeTable extends Migration
{
    public function up()
    {
        Schema::create('car_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_name');
            $table->integer('car_type_status')->default(0);
            // Ajoutez d'autres colonnes si nécessaire
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_type');
    }
}
