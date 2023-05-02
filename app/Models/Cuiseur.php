<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuiseur extends Model
{
    use HasFactory;
    protected $table = 'cuiseurs';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'designation',
    ];
}
//