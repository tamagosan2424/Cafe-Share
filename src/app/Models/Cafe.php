<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cafe extends Model
{
    public function reviews()
        { return $this->hasMany(Review::class); }

    //代入許可カラムの宣言
    protected $fillable =[
        'user_id', 'name', 'description','address',
        'phone_number', 'opening_at', 'closing_at',
        'image',
    ];

    public function cafeImages() {
    return $this->hasMany(CafeImage::class);
    }
}
