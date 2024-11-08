<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHasTravelToAutoCompanyTable extends Migration
{
    public function up()
    {
        Schema::table('auto_company', function (Blueprint $table) {
            $table->boolean('has_travel')->default(0); // Ajoutez la colonne has_travel
        });
    }

    public function down()
    {
        Schema::table('auto_company', function (Blueprint $table) {
            $table->dropColumn('has_travel'); // Supprimez la colonne si nécessaire
        });
    }
}
