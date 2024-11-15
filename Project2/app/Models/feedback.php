<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'content',
        'user_id'
    ];
    function user(){
        return $this->belongsTo(User::class,'user_id');
    }

}
