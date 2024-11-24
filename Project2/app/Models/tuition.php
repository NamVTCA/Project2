<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tuition extends Model
{
    use HasFactory;
    protected $fillable = [
        'semester',
        'child_id',
        'status'
    ];
    function child(){
        return $this->belongsTo(child::class,'child_id');
    }
    function tuition_info(){
        return $this->hasMany(tuition_info::class,'tuition_id');
    }
    // App\Models\Tuition.php
public function classroom()
{
    return $this->belongsTo(Classroom::class);
}

}
