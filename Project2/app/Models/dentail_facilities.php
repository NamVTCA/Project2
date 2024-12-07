<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dentail_facilities extends Model
{
    use HasFactory;
        protected $fillable = [
        'name',
        'status',
        'total_id',
        'quantity'
    ];
    function Total(){
        return $this->belongsTo(total_facilities::class,'total_id');
    }
}
