<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Role extends Model
{
    use HasFactory;
    protected $table = 'user_roles';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    
    public function getAdminRole()
    {
        return  $this->belongsTo(Admin_Role::class,'role_id');
    }
    
    public function getUser()
    {
        return  $this->belongsTo(User::class,'user_id');
    }
}


