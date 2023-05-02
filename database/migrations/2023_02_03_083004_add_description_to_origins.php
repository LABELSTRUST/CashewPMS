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
            $table->timestamp('date_charg')->nullable();
            $table->string('name_transporter')->nullable();
            $table->integer('nb_sacks')->nullable();
            $table->string('poids_theorique')->nullable();
            $table->string('marque_cam')->nullable();
            $table->string('immatriculation_camion')->nullable();
            $table->string('name_driver')->nullable();
            $table->string('num_permis')->nullable();
            $table->timestamp('date_time_decharge')->nullable();
            $table->string('name_export')->nullable();
            $table->string('port_decharge')->nullable();
            $table->string('code_export')->nullable();
            $table->string('pont_bascule')->nullable();
            $table->string('name_magasin')->nullable();
            $table->integer('qte_decharge')->nullable();
            $table->integer('nb_sac_return')->nullable();
            $table->string('brut_weight')->nullable();
            $table->string('net_weight')->nullable();
            $table->string('devise')->nullable();
        });
    }
    /*
















 */



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
