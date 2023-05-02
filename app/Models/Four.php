<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Four extends Model
{
    use HasFactory;
    protected $table = 'fours';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'designation',
        'code'
    ];
}

