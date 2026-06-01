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
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
