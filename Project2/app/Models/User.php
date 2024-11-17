<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'password', 'email', 'name', 'id_number', 'address', 
        'role', 'status', 'img', 'gender', 'phone', 

    ];
    public function children()
    {
        return $this->hasMany(Child::class, 'user_id');
    }
   public function classroom()
    {
        return $this->hasOne(classroom::class, 'user_id');
    }
     public function feedback()
    {
        return $this->hasMany(feedback::class, 'user_id');
    }
}
