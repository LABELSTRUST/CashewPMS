<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sequence extends Model
{
    use HasFactory;

    protected $table = 'sequences';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'quantity',
        'date_start',
        'date_end',
        'quantity_do',
        'code',
        'planning_id',
        'ligne_id',
        'objectif_id',
        'remain_quantity',
        'shift_id',
        'author_id'
    ];

    public function planning()
    {
        return $this->belongsTo(Planning::class,'planning_id');
    }

    
    public function getShift()
    {
        return  $this->belongsTo(Shift::class,'shift_id');
    }
    public function getLigne()
    {
        return  $this->belongsTo(Ligne::class,'ligne_id');
    }
    public function getObjectif()
    {
        return  $this->belongsTo(Objectif::class,'objectif_id');
    }

}/**quantity
date_start
date_end
quantity_do */
