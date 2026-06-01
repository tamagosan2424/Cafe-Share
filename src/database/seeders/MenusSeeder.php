<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('menus')->insert([
            [
                'cafe_id'       => 1,
                'name'          => 'マンデリン',
                'description'   => '深煎りされている苦めのコーヒーです。',
                'price'         => 500,
                'image'         => 'https://example.com/images/mandelin.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
