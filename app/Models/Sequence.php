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
        'planning_id'
    ];

    public function planning()
    {
        return $this->belongsTo(Planning::class,'planning_id');
    }

}/**quantity
date_start
date_end
quantity_do */
