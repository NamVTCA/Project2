<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'classroom_id'
    ];
    function classroom(){
        return $this->belongsTo(classroom::class,'classroom_id');
    }
    function schedule_info(){
        return $this->hasMany(schedule_info::class,'schedule_id');
    }
}
