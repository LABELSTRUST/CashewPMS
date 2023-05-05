<?php

namespace App\Models;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sortie extends Model
{
    use HasFactory;
    protected $table = 'sorties';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'conditioning_id',
        'num_bag',
        'remain_bag',
        'initial_quantity',
        'client_id',
        'commande_id'
    ];


    public function getUser()
    {
        return  $this->belongsTo(Client::class,'client_id');
    }


    public function getConditioning()
    {
        return  $this->belongsTo(Conditionnement::class,'conditioning_id');
    }

    
    public function getCommande()
    {
        return  $this->belongsTo(Commande::class,'commande_id');
    }
}

