<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribution extends Model
{
    use HasFactory;
    protected $table = 'attributions';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'poste_id',
        'user_id',
    ];
    
    public function getPoste()
    {
        return  $this->belongsTo(Poste::class,'poste_id');
    }
    public function getUser()
    {
        return  $this->belongsTo(User::class,'user_id');
    }
}
