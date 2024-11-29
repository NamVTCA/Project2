<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class facilities extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status',
        'classroom_id',
        'quantity'
    ];
    function classrooms(){
        return $this->belongsTo(classroom::class,'classroom_id');
    }
}
