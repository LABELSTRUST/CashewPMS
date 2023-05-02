<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assigner extends Model
{
    use HasFactory;
    
    protected $table = 'assigners';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'poste_id',
        'ligne_id',
        'user_id',
        'date_start',
        'date_end',
        'author_id',
        'shift_id',
        'sequence_id'
    ];
    


    
    public function getPoste()
    {
        return  $this->belongsTo(Poste::class,'poste_id');
    }
    public function getLigne()
    {
        return  $this->belongsTo(Ligne::class,'ligne_id');
    }
    public function getUser()
    {
        return  $this->belongsTo(User::class,'user_id');
    }
    public function getShift()
    {
        return  $this->belongsTo(Shift::class,'shift_id');
    }
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
}


