<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->unsignedBigInteger('job_id')->nullable(); // Ajoutez la colonne job_id
    });
}

public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('job_id'); // Supprimez la colonne en cas de rollback
    });
}

};
