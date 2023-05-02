<?php

namespace App\Models;

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
        'client_id'
    ];


    public function getUser()
    {
        return  $this->belongsTo(Client::class,'client_id');
    }


    public function getConditioning()
    {
        return  $this->belongsTo(Conditionnement::class,'conditioning_id');
    }
}

