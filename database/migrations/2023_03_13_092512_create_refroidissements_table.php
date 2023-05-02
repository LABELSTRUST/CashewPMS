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
        Schema::create('refroidissements', function (Blueprint $table) {
            $table->id();
            $table->string('weight_after_cook')->nullable();
            $table->string('weight_after_cooling')->nullable();
            $table->string('gap')->nullable();
            $table->string('start_temp')->nullable();
            $table->string('end_temp')->nullable();
            $table->boolean('transfert')->default(false);
            $table->unsignedBigInteger('fragilisation_id')->nullable();
            $table->foreign('fragilisation_id')->references('id')->on('fragilisations')->onDelete('set null');
            $table->unsignedBigInteger('sequence_id')->nullable();
            $table->foreign('sequence_id')->references('id')->on('sequences')->onDelete('set null');
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
        Schema::dropIfExists('refroidissements');
    }
};
