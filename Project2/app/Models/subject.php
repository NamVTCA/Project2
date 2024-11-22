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
     public function schedule_info()
    {
        return $this->belongsTo(schedule_info::class, 'subject_id');
    }
    
}
