<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReductionCommercialeToAssuranceAutoInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assurance_auto_infos', function (Blueprint $table) {
           $table->integer('reduction_commerciale')->after('subscription_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('assurance_auto_infos', function (Blueprint $table) {
            if (Schema::hasColumn('assurance_auto_infos', 'reduction_commerciale'))
             {
                 $table->dropColumn('reduction_commerciale');
            }
        });
    }
}
