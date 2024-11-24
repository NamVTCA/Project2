<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classroom extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'user_id',
    ];
    function user(){
        return $this->belongsTo(User::class,'user_id');
    }
     function facilities(){
        return $this->hasMany(facilities::class,'classroom_id');
    }
    function schedule(){
        return $this->hasMany(schedule::class,'classroom_id');
    }
    public function children()
{
    return $this->belongsToMany(child::class, 'childclasses', 'classroom_id', 'child_id');
}

public function tuitions()
{
    return $this->hasMany(Tuition::class);
}

}
