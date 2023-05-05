<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_member extends Model
{
    use HasFactory;
    protected $table = 'admin_members';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'title'
    ];

    
    public function getUser()
    {
        return  $this->belongsTo(User::class,'user_id');
    }
}
