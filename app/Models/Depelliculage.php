<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depelliculage extends Model
{
    use HasFactory;
    protected $table = 'depelliculages';
    protected $primaryKey = 'id';
    protected $name = "depelliculages";
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'author_id',
        'weight',
        'transfert',
        'unskinning_batch',
        'drying_id',
        'weight_cj'
    ];


    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    public function getDrying()
    {
        return  $this->belongsTo(Sechage2::class,'drying_id');
    }
}
/* 


 */