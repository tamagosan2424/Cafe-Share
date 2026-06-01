<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profiles')->insert([
            'user_id'       => '1',
            'nickname'      => Str::random(5),
            'bio'           => 'よろしくお願いします。',
            'image'         => 'https://example.com/image/profile',
            'created_at'    => now(),
            'updated_at'    => now(),            
        ]);
    }
}
