<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class total_facilities extends Model
{
    use HasFactory;
      protected $fillable = [
        'name'
    ];
    function dentail(){
        return $this->hasMany(dentail_facilities::class,'total_id');
    }
}
