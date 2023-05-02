<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportClassification extends Model
{
    use HasFactory;
    protected $table = 'rapport_classifications';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'classification_id',
        'observation',
        'name',
        'first_name',
        'author_id'
    ];
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    public function getClassification()
    {
        return  $this->belongsTo(Classification::class,'classification_id');
    }
    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
}
