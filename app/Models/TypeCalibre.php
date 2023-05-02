<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeCalibre extends Model
{
    use HasFactory;
    protected $table = 'type_calibres';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'designation',
        'code_calibre',
    ];
    
    
}
/* 


 */