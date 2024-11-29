<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Childclass extends Model
{
    use HasFactory;

    protected $fillable = ['child_id', 'classroom_id'];


    public function child()
    {
        return $this->belongsTo(Child::class, 'child_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }
}
