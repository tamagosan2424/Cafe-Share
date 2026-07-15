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
        // バリデーションしたデータにユーザIDを付与
        $validated['user_id'] = $request->user()->id;

        // メイン画像（1枚）を保存
        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put('cafe_image', $request->file('image'));
            $validated['image'] = '/storage/' . $path;
        }

        // sub_images はcafesテーブルにないので除外してからcreate
        unset($validated['sub_images']);
        $cafe = Cafe::create($validated);

        return redirect()->route('dashboard');
    }

    public function show(Cafe $cafe){
        $cafe->load('reviews.user', 'menus')  // ←レビュー+投稿者名、メニュー
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

        // メイン画像の更新（選択された場合のみ上書き、なければ既存を保持）
        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put('cafe_image', $request->file('image'));
            $validated['image'] = '/storage/' . $path;
        } else {
            unset($validated['image']);
        }

        // sub_images はcafesテーブルにないので除外してからupdate
        unset($validated['sub_images']);
        $cafe->update($validated);

        // サブ画像を追加（cafe_images テーブルに保存）
        if ($request->hasFile('sub_images')) {
            foreach ($request->file('sub_images') as $subImage) {
                $path = Storage::disk('public')->put('cafe_image', $subImage);
                $cafe->cafeImages()->create(['image' => '/storage/' . $path]);
            }
        }

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


