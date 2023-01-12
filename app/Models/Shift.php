<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    
    protected $table = 'shifts';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'title',
        'time_open',
        'time_close'
    ];
    
    
}
