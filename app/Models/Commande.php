<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    protected $table = 'commandes';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'produit_id',
        'quantity',
        'date_liv',
        'client_id',
        'statut',
        'code',
    ];

    
    public function getClient()
    {
        return  $this->belongsTo(Client::class,'client_id');
    }
    public function getProduit()
    {
        return  $this->belongsTo(Produit::class,'produit_id');
    }

}