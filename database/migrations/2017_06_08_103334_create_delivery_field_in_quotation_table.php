<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryFieldInQuotationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('quotation', function (Blueprint $table) {
            $table->string('phone_client',100)->nullable()->after('service_opt');
            $table->text('delivery_location')->nullable()->after('service_opt');
            $table->float('inbox_amount')->default(0)->after('service_opt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::table('quotation', function (Blueprint $table) {
            if (Schema::hasColumn('quotation', 'phone_client'))
            {
                 $table->dropColumn('phone_client');
            }

            if (Schema::hasColumn('quotation', 'delivery_location'))
            {
                 $table->dropColumn('delivery_location');
            }

        });
    }
}
