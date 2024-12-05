<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dentail_fatilities extends Model
{
    use HasFactory;
        protected $fillable = [
        'name',
        'status',
        'total_id',
        'quantity'
    ];
    function Total(){
        return $this->belongsTo(total_fatilities::class,'total_id');
    }
}
