<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RapportFragilisation extends Model
{
    use HasFactory;
    protected $table = 'rapport_fragilisations';
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $fillable = [
        'sequence_id',
        'author_id',
        'calibrage_id',
        'observation',
        'name',
        'first_name',
        'workforce'
    ];
    public function getSequence()
    {
        return  $this->belongsTo(Sequence::class,'sequence_id');
    }
    public function getUser()
    {
        return  $this->belongsTo(User::class,'author_id');
    }
    public function getCalibrage()
    {
        return  $this->belongsTo(Calibrage::class,'calibrage_id');
    }
}






