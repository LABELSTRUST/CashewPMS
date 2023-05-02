<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('origine_prods', function (Blueprint $table) {
            $table->id();
            $table->string('total_weight');
            $table->timestamp('date_recep');
            $table->integer('sacks_bought');
            $table->integer('sack_transmit');
            $table->string('campagne');
            $table->string('rep_usine');
            $table->string('cooperative');
            $table->string('id_lot_externe');
            $table->string('id_lot_pms');
            $table->string('unit_price');
            $table->string('amount_paid');
            $table->unsignedBigInteger('matiere_id')->nullable();
            $table->foreign('matiere_id')->references('id')->on('matiere_premieres')->onDelete('set null');
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
        Schema::dropIfExists('origine_prods');
    }
};
