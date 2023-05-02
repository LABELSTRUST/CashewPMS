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
        Schema::create('decorticages', function (Blueprint $table) {
            $table->id();
            $table->string('kor_after')->nullable();
            $table->string('capacity')->nullable();
            $table->string('tool')->nullable();
            $table->string('gap')->nullable();
            $table->string('sub_batch_caliber')->nullable();
            $table->string('weight')->nullable();
            $table->string('total_weight')->nullable();
            $table->string('bag_Number')->nullable();
            $table->unsignedBigInteger('sequence_id')->nullable();
            $table->foreign('sequence_id')->references('id')->on('sequences')->onDelete('set null');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('cooling_id')->nullable();
            $table->foreign('cooling_id')->references('id')->on('refroidissements')->onDelete('set null');
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
        Schema::dropIfExists('decorticages');
    }
};
