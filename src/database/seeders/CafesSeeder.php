<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CafesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cafes')->insert([
            [
                'user_id'      => 1,
                'name'         => '山田珈琲店',
                'description'  => '静かで心が落ち着く場所です',
                'address'      => '東京都渋谷区1-1-1',
                'phone_number' => '03-1234-5678',
                'opening_at'   => '09:00:00',
                'closing_at'   => '20:00:00',
                'image'        => '/storage/cafe_image/4jUo0vqjfaipbNDOp57MaykjD8rn0FwKMTdOE50e.webp',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'user_id'      => 2,
                'name'         => 'ブルーバード珈琲',
                'description'  => 'こだわりのスペシャルティコーヒーが楽しめます。',
                'address'      => '東京都新宿区2-2-2',
                'phone_number' => '03-9876-5432',
                'opening_at'   => '10:00:00',
                'closing_at'   => '21:00:00',
                'image'        => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'user_id'      => 3,
                'name'         => '無名珈琲店',
                'description'  => '閑古鳥が鳴いてます',
                'address'      => '東京都新宿区3-3-3',
                'phone_number' => '03-9876-5432',
                'opening_at'   => '8:00:00',
                'closing_at'   => '9:00:00',
                'image'        => null,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
