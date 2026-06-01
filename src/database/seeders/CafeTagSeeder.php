<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CafeTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cafe_tag')->insert([
            [
                'cafe_id'       => '1',
                'tag_id'        => '1',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],    
        ]);

    }
}
