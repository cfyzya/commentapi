<?php

namespace Database\Seeders;

use App\Models\Comments;
use App\Models\News;
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
//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//            'password' => '1234qwer',
//        ]);

        User::factory()->count(5)->create();
        News::factory()->count(5)->create();
        Comments::factory()->count(5)->create();
        Comments::factory()->count(5)->negativeRating()->create();
    }
}
