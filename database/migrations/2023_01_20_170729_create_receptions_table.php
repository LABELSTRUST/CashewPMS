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
        Schema::create('receptions', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_weight_kg', 10, 2);
            $table->timestamp('date_reception');
            $table->integer('nb_sacks_bought');
            $table->integer('unit_price_cfa');
            $table->string('id_lot_externe');
            $table->string('provenance');
            $table->string('transporteur');
            $table->string('immatriculation_camion');
            $table->string('num_ticket_pesage');
            $table->decimal('poids_brut_theorique', 10, 2);
            $table->integer('tare_palette_plus_sacs');
            $table->decimal('poids_net_theorique', 10, 2);
            $table->decimal('taux_humidite', 10, 2);
            $table->decimal('kor', 10, 2);
            $table->string('observations');
            $table->string('rep_usine');
            $table->string('cooperative');
            $table->string('nom_chauffeur');
            $table->unsignedBigInteger('campaign_id')->nullable();
            $table->foreign('campaign_id')->references('id')->on('campaigns')->onDelete('set null');
            $table->unsignedBigInteger('produit_id')->nullable();
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('set null');
            $table->unsignedBigInteger('magasinier_id')->nullable();
            $table->foreign('magasinier_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }
/*date_reception
pm_campaign_id
nb_sacks_bought
total_weight_kg
unit_price_cfa
amount_paid_cfa

récept
id_lot_externe
provenance
transporteur
immatriculation_camion
num_ticket_pesage
poids_brut_theorique
tare_palette_plus_sacs
poids_net_theorique
taux_humidite
kor
observations
nom_chauffeur
*/


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receptions');
    }
};
