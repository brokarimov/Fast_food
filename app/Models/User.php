<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = 
    [
        'name',
        'email',
        'role',
        'image',
        'password',
    ];

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }
}
