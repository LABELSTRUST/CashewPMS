<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportSechage extends Model
{
    use HasFactory;
    protected $table = 'rapport_sechages';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'drying_id',
        'observation',
        'name',
        'first_name',
        'author_id',
        'workforce'
    ];
    
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    public function getStock()
    {
        return  $this->belongsTo(Sechage2::class,'drying_id');
    }
    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
}
