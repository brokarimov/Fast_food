<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaiterOrder extends Model
{
    protected $fillable = 
    [
        'order_id',
        'employee_id',
        'date',
    ];
    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
