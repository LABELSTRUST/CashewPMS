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
        Schema::table('sequences', function (Blueprint $table) {
            $table->unsignedBigInteger('ligne_id')->nullable();
            $table->foreign('ligne_id')->references('id')->on('lignes')->onDelete('set null');
            $table->unsignedBigInteger('objectif_id')->nullable();
            $table->foreign('objectif_id')->references('id')->on('objectifs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sequences', function (Blueprint $table) {
            //
        });
    }
};
