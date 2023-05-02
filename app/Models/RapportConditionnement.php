<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportConditionnement extends Model
{
    use HasFactory;
    protected $table = 'rapport_conditionnements';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'conditioning_id',
        'observation',
        'author_id',
        'workforce'
    ];
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    public function getConditioning()
    {
        return  $this->belongsTo(Conditionnement::class,'conditioning_id');
    }
    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
}


