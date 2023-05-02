<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sechage2 extends Model
{
    use HasFactory;

    protected $table = 'sechage2s';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'initial_temp',
        'start_time',
        'end_time',
        'weigth_before',
        'weigth_after',
        'loss',
        'four_id',
        'drying1_id',
        'end_countdown',
        'final_temp',
        'transfert',
        'sequence_id',
        'author_id'
    ];
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }

    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }


    public function getFour()
    {
        return  $this->belongsTo(Four::class,'four_id');
    }
    
    public function getFirstDrying()
    {
        return  $this->belongsTo(Sechage::class,'drying1_id');
    }
}