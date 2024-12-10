<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'image'
    ];
    
    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function orterItems()
    {
        return $this->belongsToMany(Food::class, 'order_items', 'food_id', 'order_id');
    }
}
