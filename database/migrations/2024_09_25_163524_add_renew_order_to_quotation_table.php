<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('quotation', function (Blueprint $table) {
            // Ajoute une colonne 'renew_order' qui peut être nulle
            $table->integer('renew_order')->nullable()->after('view');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quotation', function (Blueprint $table) {
            // Vérifie si la colonne 'renew_order' existe avant de la supprimer
            if (Schema::hasColumn('quotation', 'renew_order')) {
                $table->dropColumn('renew_order');
            }
        });
    }
};
