<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $fillable = ['cafe_id', 'name', 'description', 'price', 'image'];

    public function cafe()
    {
        return $this->belongsTo(Cafe::class);
    }
}
