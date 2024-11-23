<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory,Notifiable;
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
    /**
     * Kiểm tra nếu user là giáo viên.
     *
     * @return bool
     */
    public function isTeacher()
    {
        return $this->role === 1; 
    }

    /**
     * Kiểm tra nếu user là phụ huynh.
     *
     * @return bool
     */
    public function isParent()
    {
        return $this->role === 2; 
    }
}
