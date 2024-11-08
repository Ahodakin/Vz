<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssuranceAutoInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assurance_auto_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('guarante', 255);
            $table->date('releasedate');

            // Utiliser un entier non signé pour periode
            $table->unsignedInteger('periode');
            $table->foreign('periode')->references('id')->on('periode')->onUpdate('cascade')->onDelete('cascade');

            $table->string('subscription_type', 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assurance_auto_infos');
    }
}
