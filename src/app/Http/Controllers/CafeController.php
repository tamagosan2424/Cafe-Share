<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;

class CafeController extends Controller
{
    public function index()
    {
        $users = User::all(); //データを取得
        return view('cafe.index',['users'=>$users]);
    }
}
