<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'user_id'       => '1',
                'cafe_id'       => '1',
                'rating'        => '5',
                'comment'       =>'作業にも向いているし、味も最高です。',
                'created_at'    => now(),
                'updated_at'    => now(),               
            ],
            [
                'user_id'       => '2',
                'cafe_id'       => '2',
                'rating'        => '3',
                'comment'       =>'待ち時間が長くて嫌だった。',
                'created_at'    => now(),
                'updated_at'    => now(),                  
            ],
            [
                'user_id'       => '2',
                'cafe_id'       => '1',
                'rating'        => '4',
                'comment'       =>'平均点を出してみたい。',
                'created_at'    => now(),
                'updated_at'    => now(),                  
            ],            
        ]);
    }
}
