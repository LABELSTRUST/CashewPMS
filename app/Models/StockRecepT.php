<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRecepT extends Model
{
    use HasFactory;
    protected $table = 'stock_recep_t_s';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $name = "StockRecepT";

    protected $fillable = [
        'transfert',
        'stock_id',
        'net_weight',
        'matiere_id',
        'section_id',
        'id_lot_transfert',
        'new_id_lot_transfert',
        'calibrated_stock'
    ];
    public function getStock()
    {
        return  $this->belongsTo(Stock::class,'stock_id');
    }
    public function getMat()
    {
        return  $this->belongsTo(MatierePremiere::class,'matiere_id');
    }
    public function getSection()
    {
        return  $this->belongsTo(Poste::class,'section_id');
    }
}
