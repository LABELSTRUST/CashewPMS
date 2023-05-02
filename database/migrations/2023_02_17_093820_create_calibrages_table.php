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
        Schema::create('calibrages', function (Blueprint $table) {
            $table->id();
            $table->string('name_seizer')->nullable();
            $table->string('rejection_weight')->nullable();
            $table->string('net_weight')->nullable();
            $table->string('caliber_weight')->nullable();
            $table->string('localisation')->nullable();
            $table->unsignedBigInteger('stock_id')->nullable();
            $table->foreign('stock_id')->references('id')->on('stocks')->onDelete('set null');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('calibre_id')->nullable();
            $table->foreign('calibre_id')->references('id')->on('type_calibres')->onDelete('set null');
            $table->timestamps();
        });//
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calibrages');
    }
};
