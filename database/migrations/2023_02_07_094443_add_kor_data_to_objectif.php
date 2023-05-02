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
        Schema::table('origine_prods', function (Blueprint $table) {
            $table->float('grainage')->nullable();
            $table->float('taux_humidite')->nullable();
            $table->float('default_thaux')->nullable();
            $table->float('kor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('origine_prods', function (Blueprint $table) {
            //
        });
    }
};
