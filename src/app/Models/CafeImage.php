<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeImage extends Model
{
    public $timestamps = false;  // cafe_imagesテーブルにタイムスタンプカラムがないため無効化

    protected $fillable = ['cafe_id', 'image'];
    public function cafe() { return $this->belongsTo(Cafe::class); }
}
