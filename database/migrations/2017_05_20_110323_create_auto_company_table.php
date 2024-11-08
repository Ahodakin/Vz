<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('compname',100);
            $table->text('compdesc');
            $table->text('complocation');
            $table->string('compphone',100);
            $table->string('complogo',255);
            $table->string('baseguar',100);
            $table->string('tsimple',255);
            $table->string('tcomplet',255);
            $table->string('tcol',255);
            $table->string('toutrisque',255);
            $table->integer('enabled');
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
        Schema::dropIfExists('auto_company');
    }
}
