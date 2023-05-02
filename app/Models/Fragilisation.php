<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fragilisation extends Model
{
    use HasFactory;
    protected $table = 'fragilisations';
    protected $primaryKey = 'id';
    protected $name = "fragilisations";
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'author_id',
        'net_weigth',
        'cooking_time',
        'pressure',
        'transfert',
        'callibre_stock_id',
        'cuiseur_id',
        'cook_net_weigth',
        'end_cooling',
        'end_countdown',
        'end_counting_cooling',
        'total_weight'
    ];
    
    
    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    
    public function getCalibrage()
    {
        return  $this->belongsTo(Calibrage::class,'callibre_stock_id');
    }
    public function getCuiseur()
    {
        return  $this->belongsTo(Cuiseur::class,'cuiseur_id');
    }
}
/**net_weigth
cooking_time
pressure
transfert
callibre_stock_id

author_id */