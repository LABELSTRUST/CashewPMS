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
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->string('weight')->nullable();
            $table->boolean('transfert')->default(false);
            $table->unsignedBigInteger('unskinning_id')->nullable();
            $table->foreign('unskinning_id')->references('id')->on('depelliculages')->onDelete('set null');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('sequence_id')->nullable();
            $table->foreign('sequence_id')->references('id')->on('sequences')->onDelete('set null');
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->foreign('grade_id')->references('id')->on('grades')->onDelete('set null');
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
        Schema::dropIfExists('classifications');
    }
};
