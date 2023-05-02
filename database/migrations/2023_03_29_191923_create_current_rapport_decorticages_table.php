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
        Schema::create('current_rapport_decorticages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sequence_id')->nullable();
            $table->foreign('sequence_id')->references('id')->on('sequences')->onDelete('set null');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('shelling_id')->nullable();
            $table->foreign('shelling_id')->references('id')->on('decorticages')->onDelete('set null');
            $table->unsignedBigInteger('rapport_id')->nullable();
            $table->foreign('rapport_id')->references('id')->on('rapport_decorticages')->onDelete('set null');
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
        Schema::dropIfExists('current_rapport_decorticages');
    }
};
