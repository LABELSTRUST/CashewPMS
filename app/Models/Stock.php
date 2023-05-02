<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table = 'stocks';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'transfert',
        'origin_id',
        'net_weight'
    ];
    public function getOrigin()
    {
        return  $this->belongsTo(OrigineProd::class,'origin_id');
    }
}
/* 

 */