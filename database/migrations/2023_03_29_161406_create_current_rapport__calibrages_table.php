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
        Schema::create('current_rapport__calibrages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sequence_id')->nullable();
            $table->foreign('sequence_id')->references('id')->on('sequences')->onDelete('set null');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('calibrage_id')->nullable();
            $table->foreign('calibrage_id')->references('id')->on('calibrages')->onDelete('set null');
            $table->unsignedBigInteger('rapport_id')->nullable();
            $table->foreign('rapport_id')->references('id')->on('rapport_calibrages')->onDelete('set null');

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
        Schema::dropIfExists('current_rapport__calibrages');
    }
};
