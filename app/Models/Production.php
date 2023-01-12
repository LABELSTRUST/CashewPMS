<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;
    
    protected $table = 'productions';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'cycle',
        'user_id',
        'ligne_id',
        'shift_id',
        'produit_id'
    ];

    
    public function getShift()
    {
        return  $this->belongsTo(Shift::class,'shift_id');
    }
    public function getLigne()
    {
        return  $this->belongsTo(Ligne::class,'ligne_id');
    }
    public function getUser()
    {
        return  $this->belongsTo(User::class,'user_id');
    }
    public function getProduit()
    {
        return  $this->belongsTo(Produit::class,'produit_id');
    }
}
