<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class facilities extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'classroom_id',
        'quantity',
        'dentail_id'
    ];
    function classrooms(){
        return $this->belongsTo(classroom::class,'classroom_id');
    }
    function dentail()
    {
        return $this->belongsTo(dentail_facilities::class, 'dentail_id');
    }
}
