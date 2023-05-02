<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Decorticage extends Model
{
    use HasFactory;
    protected $table = 'decorticages';
    protected $primaryKey = 'id';
    protected $name = "decorticages";
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'author_id',
        'weight',
        'kor_after',
        'capacity',
        'tool',
        'gap',
        'sub_batch_caliber',
        'total_weight',
        'cooling_id',
        'bag_Number',
        'transfert'
    ];



    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    
    public function getCooling()
    {
        return  $this->belongsTo(Refroidissement::class,'cooling_id');
    }
    
}
