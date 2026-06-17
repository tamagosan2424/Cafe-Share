<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cafe;
use Inertia\Inertia;

class CafeController extends Controller
{
    public function index()
    {
        $cafes = Cafe::withAvg('reviews', 'rating')
        ->withCount('reviews')
        ->get(); //データを取得。
        return Inertia::render('Cafe/Index', ['cafes' => $cafes]);

        

    }

    public function create()
    {
        return Inertia::render('Cafe/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      =>'required|string|max:255',
            'address'   =>'required|string|max:255',
        ]);

        $validated['user_id']=$request->user()->id;
        Cafe::create($validated); //配列をまとめて保存
        return redirect()->route('cafe.index');
    }
}

