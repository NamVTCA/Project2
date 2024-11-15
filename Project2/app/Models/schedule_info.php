<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class schedule_info extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'schedule_id',
        'subject_id'
    ];
    function schedule(){
        return $this->belongsTo(schedule::class,'schedule_id');
    }
    function subject(){
        return $this->hasMany(subject::class,'subject_id');
    }

}
