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
        $cafes = Cafe::with('cafeImages')
        ->withAvg('reviews', 'rating')
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
        //バリデーションしたデータにユーザIDを付与
        $validated['user_id']=$request->user()->id;
        $image = $request->file('image');
        //画像が送信されてきていたら保存処理
        if($image){
            // 画像を保存してパスを取得
            $path = Storage::disk('public')->put('cafe_image', $image);
            $validated['image'] = "/storage/".$path;
        }
        Cafe::create($validated); //配列をまとめて保存
        return redirect()->route('dashboard');

    }

    public function show(Cafe $cafe){
        $cafe->load('reviews.user')  // ←レビュー+投稿者名
            ->loadAvg('reviews', 'rating')
            ->loadCount('reviews');
        $canEdit   = auth()->user()->can('update', $cafe);
        return Inertia::render('Cafe/Show', compact('cafe', 'canEdit'));
    }

    // 編集画面を表示（カフェのデータを渡す）
    public function edit(Cafe $cafe)
    {
        $this->authorize('update', $cafe);
        $canDelete = auth()->user()->can('delete', $cafe);
        return Inertia::render('Cafe/Edit', compact('cafe', 'canDelete'));
    }

    // 更新処理
    public function update(PostRequest $request, Cafe $cafe)
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            // 新しい画像がある場合のみ保存・上書き
            $path = Storage::disk('public')->put('cafe_image', $request->file('image'));
            $validated['image'] = "/storage/".$path;
        } else {
            // 画像がない場合は $validated から image を除外（既存画像を保持）
            unset($validated['image']);
        }
        $cafe->update($validated);
        return redirect()->route('cafes.show', $cafe);
    }

    // 削除処理
    public function destroy(Request $req, Cafe $cafe){
    // 保存
    $this->authorize('delete', $cafe);
    $cafe->delete();
    return redirect()->route('dashboard');
    }
}


