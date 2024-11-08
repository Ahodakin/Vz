<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsMotoToMakeTable extends Migration
{
    public function up()
    {
        Schema::table('make', function (Blueprint $table) {
            $table->boolean('isMoto')->default(0); // Ajoutez la colonne isMoto
        });
    }

    public function down()
    {
        Schema::table('make', function (Blueprint $table) {
            $table->dropColumn('isMoto'); // Supprimez la colonne si nécessaire
        });
    }
}
