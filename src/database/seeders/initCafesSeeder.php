<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB; //追加
use Illuminate\Support\Str; //追加
use Illuminate\Support\Facades\Hash; //追加
use Illuminate\Database\Seeder;

class initCafesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email'     => Str::random(10).'@gmail.com',
            'password'  => Hash::make('password'),
        ]);
    }
}
