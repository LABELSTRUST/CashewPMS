<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refroidissement extends Model
{
    use HasFactory;
    protected $table = 'refroidissements';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'weight_after_cook',
        'weight_after_cooling',
        'gap',
        'start_temp',
        'end_temp',
        'fragilisation_id',
        'sequence_id',
        'author_id',
        'transfert',
    ];
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    
    public function getFrag()
    {
        return  $this->belongsTo(Fragilisation::class,'fragilisation_id');
    }
    
    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
}