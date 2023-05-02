<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Geolocation extends Model
{
    use HasFactory;
    protected $table = 'geolocations';
    protected $primaryKey = 'id';
    protected $name = "geolocations";
    public $incrementing = true;

    protected $fillable = [
        'country',
        'town',
        'region',
        'village',
        'neighborhood',
    ];
    
}