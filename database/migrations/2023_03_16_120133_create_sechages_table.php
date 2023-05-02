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
        Schema::create('sechages', function (Blueprint $table) {
            $table->id();
            $table->string('initial_temp')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('weigth_before')->nullable();
            $table->string('weigth_after')->nullable();
            $table->string('loss')->nullable();
            $table->boolean('end_countdown')->default(false);

            $table->unsignedBigInteger('four_id')->nullable();
            $table->foreign('four_id')->references('id')->on('fours')->onDelete('set null');

            $table->unsignedBigInteger('sequence_id')->nullable();
            $table->foreign('sequence_id')->references('id')->on('sequences')->onDelete('set null');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('shelling_id')->nullable();
            $table->foreign('shelling_id')->references('id')->on('decorticages')->onDelete('set null');
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
        Schema::dropIfExists('sechages');
    }
};
