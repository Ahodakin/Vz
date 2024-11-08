<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_bonus', function (Blueprint $table) {
            $table->unsignedInteger('client_space_id');
            $table->foreign('client_space_id')->references('id')->on('client_space')->onUpdate('cascade')->onDelete('cascade');
            $table->string('desc_bonus',100);
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
        Schema::dropIfExists('client_bonus');
    }
}
