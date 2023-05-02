<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Current_rapportDecorticage extends Model
{
    use HasFactory;
    protected $table = 'current_rapport_decorticages';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'author_id',
        'shelling_id',
        'rapport_id',
    ];
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    
    public function getShelling()
    {
        return  $this->belongsTo(Decorticage::class,'shelling_id');
    }

    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
    public function getRapport()
    {
        return  $this->belongsTo(RapportDecorticage::class,'rapport_id');
    }
}

