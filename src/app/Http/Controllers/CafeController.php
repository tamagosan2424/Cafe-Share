<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CafeController extends Controller
{
    public function index()
    {
        $users = User::all(); //データを取得
        return view('cafe.index',['users'=>$users]);
    }
}
