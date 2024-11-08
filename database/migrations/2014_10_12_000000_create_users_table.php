<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname',100);
            $table->string('lastname',100);
            $table->char('gender',2)->nullable();
            $table->date('dob')->nullable();
            $table->string('contact',50)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->default("default.png");
            $table->integer('status');
            $table->integer('usertype');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
