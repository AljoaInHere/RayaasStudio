<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SetupPackage extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'category',
        'status',
        'estimation',
        'platforms',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
