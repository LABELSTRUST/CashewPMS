<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posteproduit extends Model
{
    use HasFactory;
    protected $table = 'posteproduits';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'poste_id',
        'produit_id'
    ];

    public function getProduit()
    {
        return  $this->belongsTo(Produit::class,'produit_id');
    }

    public function getPoste()
    {
        return  $this->belongsTo(Poste::class,'poste_id');
    }
}
