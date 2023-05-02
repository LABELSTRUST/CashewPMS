<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Current_rapportConditionnement extends Model
{
    use HasFactory;
    protected $table = 'current_rapport_conditionnements';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'author_id',
        'conditioning_id',
        'rapport_id',
    ];
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    
    public function getClassification()
    {
        return  $this->belongsTo(Conditionnement::class,'conditioning_id');
    }

    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
    public function getRapport()
    {
        return  $this->belongsTo(RapportFragilisation::class,'rapport_id');
    }
}
