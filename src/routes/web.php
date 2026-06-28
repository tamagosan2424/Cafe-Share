<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CafeController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});

Route::get('/', function(){
    return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [CafeController::class, 'index'])->name('dashboard');//一覧画面 トップ画面を使わないのであえて一覧画面を表示
    Route::get('cafes', [CafeController::class, 'index'])->name('cafes.index');//一覧画面
    Route::get('cafes/create', [CafeController::class, 'create'])->name('cafes.create');//新規作成画面
    Route::post('cafes', [CafeController::class, 'store'])->name('cafes.store');//作成処理
    Route::get('cafes/{cafe}', [CafeController::class, 'show'])->name('cafes.show');//詳細画面
    Route::get('cafes/{cafe}/edit', [CafeController::class, 'edit'])->name('cafes.edit');//編集画面
    Route::patch('cafes/{cafe}',    [CafeController::class, 'update'])->name('cafes.update'); // 更新処理
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
