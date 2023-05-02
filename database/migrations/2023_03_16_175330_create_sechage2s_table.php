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
        Schema::create('sechage2s', function (Blueprint $table) {
            $table->id();
            $table->string('initial_temp')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('final_temp')->nullable();
            $table->string('weigth_before')->nullable();
            $table->string('weigth_after')->nullable();
            $table->boolean('end_countdown')->default(false);
            $table->string('loss')->nullable();
            $table->unsignedBigInteger('four_id')->nullable();
            $table->foreign('four_id')->references('id')->on('fours')->onDelete('set null');
            $table->unsignedBigInteger('drying1_id')->nullable();
            $table->foreign('drying1_id')->references('id')->on('sechages')->onDelete('set null');
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
        Schema::dropIfExists('sechage2s');
    }
};
