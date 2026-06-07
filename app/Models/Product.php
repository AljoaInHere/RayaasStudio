<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'category',
        'image',
        'icon',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}