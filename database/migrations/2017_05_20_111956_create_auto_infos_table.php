<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('matriculation', 100);

            // Utiliser un entier non signé pour model_id
            $table->unsignedInteger('model_id');
            $table->foreign('model_id')->references('id')->on('model')->onUpdate('cascade')->onDelete('cascade');

            $table->string('power', 25);
            $table->char('energy', 2);

            // Utiliser un entier non signé pour category
            $table->unsignedInteger('category');
            $table->foreign('category')->references('id')->on('auto_categories')->onUpdate('cascade')->onDelete('cascade');

            $table->date('firstrelease');
            $table->integer('placesnumber');

            // Utiliser un entier non signé pour parkingzone
            $table->unsignedInteger('parkingzone');
            $table->foreign('parkingzone')->references('id')->on('city')->onUpdate('cascade')->onDelete('cascade');

            $table->double('vneuve');
            $table->double('vvenale');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_infos');
    }
}
