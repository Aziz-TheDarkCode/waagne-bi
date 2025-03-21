<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Burger extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image_path',
        'stock',
        'is_active'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
} 