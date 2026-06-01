<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            ['name' => '勉強可', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '駅近', 'created_at' => now(), 'updated_at' => now()],
            ['name' => '種類豊富', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wifi完備', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
