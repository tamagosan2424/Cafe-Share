<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cafe;
use Inertia\Inertia;

class CafeController extends Controller
{
    public function index()
    {
        $cafes = Cafe::withAvg('reviews', 'rating')->get(); //データを取得。
        return Inertia::render('Cafe/Index', ['cafes' => $cafes]);

        

    }
}
