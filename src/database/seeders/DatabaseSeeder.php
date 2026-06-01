<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UsersSeeder::class,
            ProfilesSeeder::class,
            CafesSeeder::class,
            MenusSeeder::class,
            TagsSeeder::class,            
            ReviewsSeeder::class,
            CafeTagSeeder::class,

        ]);
    }
}
