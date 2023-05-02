<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperatorSequence extends Model
{
    use HasFactory;
    protected $table = 'operator_sequences';
    protected $primaryKey = 'id';
    protected $name = "OperatorSequence";
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'user_id'
    ];
    
    
    public function getUser()
    {
        return  $this->belongsTo(User::class,'user_id');
    }
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
}
