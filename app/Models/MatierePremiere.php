<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatierePremiere extends Model
{
    use HasFactory;
    protected $table = 'matiere_premieres';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'code_mat',
        'name',
        'receptionner',
        'net_weight',
        'transfert_weight'
    ];
}

