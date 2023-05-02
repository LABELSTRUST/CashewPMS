<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;
    protected $table = 'fournisseurs';
    protected $primaryKey = 'id';
    protected $name = "fournisseurs";
    public $incrementing = true;

    protected $fillable = [
        'country',
        'tel',
        'email',
        'adresse',
        'first_name',
        'company',
        'postal_code',
        'code',
        'position',
        'city',
        'categorie',
        'name',
    ];
    
    
}







