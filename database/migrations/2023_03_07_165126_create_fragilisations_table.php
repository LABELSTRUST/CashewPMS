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
        Schema::create('fragilisations', function (Blueprint $table) {
            $table->id();
            $table->string('net_weigth')->nullable();
            $table->string('cooking_time')->nullable();
            $table->string('pressure')->nullable();
            $table->boolean('transfert')->default(false);
            $table->unsignedBigInteger('sequence_id')->nullable();
            $table->foreign('sequence_id')->references('id')->on('sequences')->onDelete('set null');
            $table->unsignedBigInteger('callibre_stock_id')->nullable();
            $table->foreign('callibre_stock_id')->references('id')->on('calibrages')->onDelete('set null');
            $table->unsignedBigInteger('cuiseur_id')->nullable();
            $table->foreign('cuiseur_id')->references('id')->on('cuiseurs')->onDelete('set null');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('fragilisations');
    }
};
