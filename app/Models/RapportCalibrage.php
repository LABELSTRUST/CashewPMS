<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportCalibrage extends Model
{
    use HasFactory;
    protected $table = 'rapport_calibrages';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'stock_cal_id',
        'observation',
        'name',
        'first_name',
        'author_id',
        'workforce'
    ];
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    public function getStock()
    {
        return  $this->belongsTo(StockRecepT::class,'stock_cal_id');
    }
    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
    
}




