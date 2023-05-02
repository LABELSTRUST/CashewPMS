<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conditionnement extends Model
{
    use HasFactory;
    protected $table = 'conditionnements';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'weight',
        'num_bag',
        'remain_bag',
        'remain_weight',
        'transfert',
        'classification_id',
        'author_id',
        'sequence_id'
    ];
    
    
    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }

    public function getClassification()
    {
        return  $this->belongsTo(Classification::class,'classification_id');
    }
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
}








