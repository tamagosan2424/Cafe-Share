<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'cafe_id', 'rating', 'comment'
    ];

    public function cafe()
        { return $this->belongsTo(Cafe::class); }

    public function user()
        { return $this->belongsTo(User::class); }
}
