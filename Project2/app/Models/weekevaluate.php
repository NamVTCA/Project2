<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weekevaluate extends Model
{
    use HasFactory;
    protected $fillable = [
        'comment',
        'point',
        'date',
        'child_id'
    ];
    function child(){
        return $this->belongsTo(child::class,'child_id');
    }
}
