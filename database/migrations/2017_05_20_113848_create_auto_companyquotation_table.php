<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoCompanyquotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_companyquotation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('companyid');
            $table->unsignedInteger('guaranteeid');
            $table->foreign('companyid')->references('id')->on('auto_company')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('guaranteeid')->references('id')->on('auto_guarantee')->onUpdate('cascade')->onDelete('cascade');
            $table->double('cost');
            $table->string('sommegarantie');
            $table->string('franchise');
            $table->integer('version');
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto_companyquotation');
    }
}
