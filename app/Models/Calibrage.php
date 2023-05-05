<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calibrage extends Model
{
    use HasFactory;
    
    protected $table = 'calibrages';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'name_seizer',
        'rejection_weight',
        'net_weight',
        'caliber_weight',
        'localisation',
        'stock_id',
        'author_id',
        'calibre_id',
        'id_lot_calibre',
        'kor',
        'taux_humidite',
        'sequence_id',
        'transfert',
        'initial_caliber_weight',
        'grainage',
        'default_thaux',
        'name_controler',
    ];
    
    
    public function getStock()
    {
        return  $this->belongsTo(StockRecepT::class,'stock_id');
    }
    
    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }

    
    public function getCalibre()
    {
        return  $this->belongsTo(TypeCalibre::class,'calibre_id');
    }
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
}