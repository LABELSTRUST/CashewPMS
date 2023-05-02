<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calibreuse extends Model
{
    use HasFactory;
    protected $table = 'calibreuses';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'code_calibreuse',
        'designation',
    ];
    
}

