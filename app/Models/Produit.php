<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;
    
    protected $table = 'produits';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'code_prod',
        'name',
    ];
}
