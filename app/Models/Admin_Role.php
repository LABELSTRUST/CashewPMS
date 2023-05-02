<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_Role extends Model
{
    use HasFactory;
    protected $table = 'admin__roles';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $fillable = [
        'designation',
    ];
}

