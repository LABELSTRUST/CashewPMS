<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;

    protected $table = 'plannings';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'commande_id',
        'shift_id',
        'ligne_id',
    ];

    
    public function getShift()
    {
        return  $this->belongsTo(Shift::class,'shift_id');
    }

    public function getCommande()
    {
        return  $this->belongsTo(Commande::class,'commande_id');
    }

    public function getLigne()
    {
        return  $this->belongsTo(Ligne::class,'ligne_id');
    }

    public function getSequence()
    {
        return  $this->hasMany(Sequence::class);
    }
}
/**commande_id
shift_id
ligne_id
sequence_id */