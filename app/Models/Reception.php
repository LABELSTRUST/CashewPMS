<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reception extends Model
{
    use HasFactory;
    protected $table = 'receptions';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'total_weight_kg',
        'date_reception',
        'nb_sacks_bought',
        'unit_price_cfa',
        'id_lot_externe',
        'provenance',
        'produit_id',
        'transporteur',
        'immatriculation_camion',
        'num_ticket_pesage',
        'poids_brut_theorique',
        'tare_palette_plus_sacs',
        'poids_net_theorique',
        'taux_humidite',
        'kor',
        'observations',
        'rep_usine',
        'cooperative',
        'nom_chauffeur',
        'campaign_id',
        'magasinier_id','batch_id'
    ];
    


    
    public function getMagasinier()
    {
        return  $this->belongsTo(User::class,'magasinier_id');
    }
    public function getCampaign()
    {
        return  $this->belongsTo(Ligne::class,'campaign_id');
    }
}
/**total_weight_kg
date_reception
nb_sacks_bought
unit_price_cfa
id_lot_externe
provenance
produit_id
transporteur
immatriculation_camion
num_ticket_pesage
poids_brut_theorique
tare_palette_plus_sacs
poids_net_theorique
taux_humidite
kor
observations
rep_usine
cooperative
nom_chauffeur
campaign_id
magasinier_id */