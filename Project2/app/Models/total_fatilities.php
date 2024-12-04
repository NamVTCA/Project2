<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class total_fatilities extends Model
{
    use HasFactory;
    function dentail(){
        return $this->hasMany(dentail_fatilities::class,'total_id');
    }
}
