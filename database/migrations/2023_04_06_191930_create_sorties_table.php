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
        Schema::create('sorties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conditioning_id')->nullable();
            $table->foreign('conditioning_id')->references('id')->on('conditionnements')->onDelete('set null');
            $table->string('num_bag')->nullable();
            $table->string('remain_bag')->nullable();
            $table->string('initial_quantity')->nullable();
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
        Schema::dropIfExists('sorties');
    }
};
