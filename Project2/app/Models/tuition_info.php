<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tuition_info extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'tuition_id'
    ];
    function tuition(){
        return $this->belongsTo(tuition::class,'tuition_id');
    }
}
