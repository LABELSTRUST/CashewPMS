<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    use HasFactory;
    protected $table = 'secteurs';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'departement_id',
        'user_id',
        'designation'
    ];
    
    public function getDepart()
    {
        return  $this->belongsTo(Admin_Role::class,'departement_id');
    }
    public function getUser()
    {
        return  $this->belongsTo(User::class,'user_id');
    }
}
/* 
departement_id
user_id */