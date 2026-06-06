<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;

class CafeController extends Controller
{
    public function index()
    {
        $users = User::all(); //データを取得
        return Inertia::render('Cafe/Index', ['users' => $users]);
    }
}
