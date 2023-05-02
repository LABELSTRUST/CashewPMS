<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sechage extends Model
{
    use HasFactory;

    protected $table = 'sechages';
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
        'sequence_id',
        'author_id',
        'shelling_id',
        'end_countdown',
        'finale_temp'
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
    public function getFour()
    {
        return  $this->belongsTo(Four::class,'four_id');
    }
}
/* 










 */