<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'setup_package_id',
        'paket',
        'harga',
        'nama',
        'metode',
        'status',
        'platform',
        'keluhan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function setupPackage()
    {
        return $this->belongsTo(SetupPackage::class, 'setup_package_id');
    }
}