<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrigineProd extends Model
{
    use HasFactory;
    protected $table = 'origine_prods';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $name = "OrigineProd";

    protected $fillable = [
        'total_weight',
        'date_recep',
        'sacks_bought',
        'sack_transmit',
        'campagne',
        'rep_usine',
        'cooperative',
        'id_lot_externe',
        'id_lot_pms',
        'unit_price',
        'amount_paid',
        'matiere_id',
        'date_charg',
        'name_transporter',
        'nb_sacks',
        'poids_theorique',
        'marque_cam',
        'immatriculation_camion',
        'name_driver',
        'num_permis',
        'date_time_decharge',
        'name_export',
        'port_decharge',
        'code_export',
        'pont_bascule',
        'name_magasin',
        'qte_decharge',
        'nb_sac_return',
        'brut_weight',
        'net_weight',
        'devise',
        
        'grainage',
        'taux_humidite',
        'default_thaux',
        'kor',
        'date_controle',
        'signature_transporteur',
        'signature_magasinier',
        'signature_controleur',
        'signature_chauffeur',
        'nom_controleur',
        'nom_mag',
        'localisation',
        'observation',
        'user_id',
        'supplier_id',
        'geolocation_id'
    ];

    public function getMatiere()
    {
        return  $this->belongsTo(MatierePremiere::class,'matiere_id');
    }
    public function getUser()
    {
        return  $this->belongsTo(User::class,'user_id');
    }
    public function geSupplier()
    {
        return  $this->belongsTo(Fournisseur::class,'supplier_id');
    }
    public function get_Geo()
    {
        return  $this->belongsTo(Geolocation::class,'geolocation_id');
    }

}
