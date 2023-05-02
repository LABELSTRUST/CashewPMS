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
        Schema::table('origine_prods', function (Blueprint $table) {
            $table->text('signature_transporteur')->nullable();
            $table->text('signature_magasinier')->nullable();
            $table->text('signature_controleur')->nullable();
            $table->string('nom_controleur')->nullable();
            $table->string('nom_mag')->nullable();
            $table->text('localisation')->nullable();
            $table->text('observation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('origine_prods', function (Blueprint $table) {
            //
        });
    }
};
