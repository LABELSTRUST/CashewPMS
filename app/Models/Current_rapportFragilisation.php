<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Current_rapportFragilisation extends Model
{
    use HasFactory;
    protected $table = 'current_rapport_fragilisations';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'author_id',
        'fragilisation_id',
        'rapport_id',
    ];
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    public function getFragilisation()
    {
        return  $this->belongsTo(Fragilisation::class,'fragilisation_id');
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



