<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objectif extends Model
{
    use HasFactory;
    protected $table = 'objectifs';
    protected $primaryKey = 'id';
    protected $name = "Objectif";
    public $incrementing = true;

    protected $fillable = [
        'id_target',
        'obj_date_start',
        'obj_date_end',
        'qte_totale',
        'produit_id',
        'obj_remain_quantity',
        'unit_measure',
        'commande_id'
    ];
    
    public function getProduit()
    {
        return  $this->belongsTo(Produit::class,'produit_id');
    }
    public function getCommande()
    {
        return  $this->belongsTo(Commande::class,'commande_id');
    }

    public function tableName(){
        return $this->name;
    }
}
/**id_target
date_start
date_end
qte_totale
produit_id */