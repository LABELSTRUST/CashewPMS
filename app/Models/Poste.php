<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poste extends Model
{
    
    use HasFactory;
    protected $table = 'postes';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable=[
        'title',
        'section_id'
    ];
    
    public function getSection()
    {
        return  $this->belongsTo(Section::class,'section_id');
    }

}
