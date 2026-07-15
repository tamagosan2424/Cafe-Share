<?php

namespace App\Http\Controllers;

use App\Models\Cafe;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    /**
     * メニューを登録する（画像含む）
     */
    public function store(Request $request, Cafe $cafe)
    {
        $this->authorize('update', $cafe);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = Storage::disk('public')->put('menu_image', $request->file('image'));
            $validated['image'] = '/storage/' . $path;
        }

        $validated['cafe_id'] = $cafe->id;
        Menu::create($validated);

        return redirect()->route('cafes.show', $cafe)
            ->with('success', 'メニューを追加しました。');
    }

    /**
     * メニューを削除する
     */
    public function destroy(Cafe $cafe, Menu $menu)
    {
        $this->authorize('update', $cafe);

        abort_if($menu->cafe_id !== $cafe->id, 403);

        // 画像ファイルをストレージから削除
        if ($menu->image) {
            $relativePath = str_replace('/storage/', '', $menu->image);
            Storage::disk('public')->delete($relativePath);
        }

        $menu->delete();

        return redirect()->route('cafes.show', $cafe)
            ->with('success', 'メニューを削除しました。');
    }
}
