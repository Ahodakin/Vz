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
        Schema::create('delivery_tour_order', function (Blueprint $table) {
            $table->id();
            $table->integer('delivery_tour_id')->unsigned(); 
            $table->integer('order_id')->unsigned();
            $table->timestamps();

            $table->foreign('delivery_tour_id')->references('id')->on('delivery_tour')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_tour_order');
    }
};
