<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cafe;
use Inertia\Inertia;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;

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

    public function store(PostRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id']=$request->user()->id;
        $image = $request->file('image');
        //画像が送信されてきていたら保存処理
        if($image){
            // 画像を保存してパスを取得
            $path = Storage::disk('public')->put('cafe_image', $image);
            $validated['image'] = $path;
        }
        Cafe::create($validated); //配列をまとめて保存
        return redirect()->route('dashboard');

    }



    public function show(Cafe $cafe){
        $cafe->loadAvg('reviews', 'rating')->loadCount('reviews');
        return Inertia::render('Cafe/Show', compact('cafe'));
    }
}

