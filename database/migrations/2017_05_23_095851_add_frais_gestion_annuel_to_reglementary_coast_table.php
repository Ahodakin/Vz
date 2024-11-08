<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFraisGestionAnnuelToReglementaryCoastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auto_reglementarycost', function (Blueprint $table) {
           $table->double('fg_annuel')->after('default_redcom');
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
            if (Schema::hasColumn('auto_reglementarycost', 'fg_annuel'))
             {
                 $table->dropColumn('fg_annuel');
            }
        });
    }
}
