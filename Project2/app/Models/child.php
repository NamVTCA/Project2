<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class child extends Model
{
     use HasFactory;
    protected $fillable = [
        'name','birthDate','gender','user_id','img','status',
    ];
     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function attendant(){
        return $this->hasMany(Attendant::class,'child_id');
    }
    public function tuition(){
        return $this->hasMany(tuition::class,'child_id');
    }
    public function classroom()
    {
        return $this->belongsToMany(classroom::class, 'childclasses', 'child_id', 'classroom_id');
    }
    function weekevaluate(){
        return $this->hasMany(weekevaluate::class,'child_id');
    }
}
