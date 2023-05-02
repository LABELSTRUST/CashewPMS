<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventConfig extends Model
{
    use HasFactory;
    protected $table = 'invent_configs';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'code_config',
        'name',
    ];
}
