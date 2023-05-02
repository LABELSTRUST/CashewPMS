<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General_admin extends Model
{
    use HasFactory;
    protected $table = 'general_admins';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
    ];

    
    public function getUser()
    {
        return  $this->belongsTo(User::class,'user_id');
    }
}
