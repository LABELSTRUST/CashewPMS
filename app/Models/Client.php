<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'name',
        'email',
        'country',
        'tel',
        'adresse',
        'first_name',
        'company',
        'postal_code',
        'code',
        'position',
        'city',
        'categorie'
        
    ];
    
    
    
    





}
