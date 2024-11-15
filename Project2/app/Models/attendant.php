<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendant extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'child_id',
        'status'
    ];
    function children(){
        return $this->belongsTo(Child::class,'child_id');
    }
}
