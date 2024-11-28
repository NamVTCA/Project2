<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class childclass extends Model
{
    use HasFactory;
    protected $fillable = ['child_Id', 'classroom_Id'];
}
