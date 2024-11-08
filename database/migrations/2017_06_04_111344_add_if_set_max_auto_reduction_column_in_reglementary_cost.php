<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIfSetMaxAutoReductionColumnInReglementaryCost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auto_reglementarycost', function (Blueprint $table) {
            $table->integer('active_max_discount')->nullable(); // Ajoutez 'nullable()' si la colonne peut être vide
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auto_reglementarycost', function (Blueprint $table) {
            if (Schema::hasColumn('auto_reglementarycost', 'active_max_discount')) {
                $table->dropColumn('active_max_discount');
            }
        });
    }
}
