<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportDecorticage extends Model
{
    use HasFactory;
    protected $table = 'rapport_decorticages';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'author_id',
        'shelling_id',
        'observation',
        'name',
        'first_name',
        'workforce'
    ];
    

    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }

    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }

    public function getShelling()
    {
        return  $this->belongsTo(Decorticage::class,'shelling_id');
    }
}

