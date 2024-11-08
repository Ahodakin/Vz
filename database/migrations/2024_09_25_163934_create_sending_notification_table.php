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
        Schema::create('sending_notification', function (Blueprint $table) {
            $table->id();
            $table->string('type_notif');            
            $table->unsignedInteger('from_user'); // Utilisateur qui envoie la notification
            $table->unsignedInteger('to_user');   // Utilisateur qui reçoit la notification            
            $table->string('head_notif');            
            $table->text('body_notif');            
            $table->timestamps();

            // Ajout de clés étrangères
            $table->foreign('from_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_user')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sending_notification');
    }
};
