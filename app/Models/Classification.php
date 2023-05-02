<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;
    protected $table = 'classifications';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'weight',
        'author_id',
        'sequence_id',
        'transfert',
        'unskinning_id',
        'grade_id'
    ];
    
    public function getGrade()
    {
        return  $this->belongsTo(Grade::class,'grade_id');
    }
    
    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }

    public function getUnskinning()
    {
        return  $this->belongsTo(Depelliculage::class,'unskinning_id');
    }
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
}
