<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];
    function subject(){
        return $this->belongsTo(schedule_info::class,'subject_id');
    }
    
}
