<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'address',
        'phone_number',
        'opening_at',
        'closing_at',
        'image',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function cafeImages()
    {
        return $this->hasMany(CafeImage::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
