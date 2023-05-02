<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Current_rapportSechage extends Model
{
    use HasFactory;
    protected $table = 'current_rapport_sechages';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'author_id',
        'drying_id',
        'rapport_id',
    ];
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    
    public function getDrying()
    {
        return  $this->belongsTo(Sechage2::class,'drying_id');
    }

    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
    public function getRapport()
    {
        return  $this->belongsTo(RapportSechage::class,'rapport_id');
    }
}


