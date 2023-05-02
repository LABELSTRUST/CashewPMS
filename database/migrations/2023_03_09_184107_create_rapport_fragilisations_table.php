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
        Schema::create('rapport_fragilisations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sequence_id')->nullable();
            $table->foreign('sequence_id')->references('id')->on('sequences')->onDelete('set null');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('calibrage_id')->nullable();
            $table->foreign('calibrage_id')->references('id')->on('calibrages')->onDelete('set null');
            $table->text('observation')->nullable();
            $table->string('name')->nullable();
            $table->text('first_name')->nullable();
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
        Schema::dropIfExists('rapport_fragilisations');
    }
};
