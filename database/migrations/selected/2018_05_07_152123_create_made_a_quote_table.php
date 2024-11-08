<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMadeAQuoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('made_quote', function (Blueprint $table) {
            $table->integer('quote_id')->unsigned(); // Ajoutez `unsigned` si `id` sur `quotation` est non signé
            $table->foreign('quote_id')->references('id')->on('quotation')->onDelete('cascade'); // Ajoutez une contrainte de suppression si nécessaire

            $table->integer('account_id')->unsigned(); // Ajoutez `unsigned` si `id` sur `espace_perso_account` est non signé
            $table->foreign('account_id')->references('id')->on('espace_perso_account')->onDelete('cascade'); // Ajoutez une contrainte de suppression si nécessaire

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
        Schema::dropIfExists('made_quote');
    }
}
