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
        Schema::create('sequences', function (Blueprint $table) {
            $table->id();
            $table->string('quantity');
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->string('quantity_do')->nullable();
            $table->unsignedBigInteger('planning_id')->nullable();
            $table->foreign('planning_id')->references('id')->on('plannings')->onDelete('set null');
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
        Schema::dropIfExists('sequences');
    }
};
