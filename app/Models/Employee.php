<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'department_id',
        'salary_type',
        'salary',
        'bonus',
        'monthly_time',
        'day_start',
        'day_end',
        'daily_time',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
