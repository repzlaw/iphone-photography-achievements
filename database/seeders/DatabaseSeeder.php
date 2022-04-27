<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AchievementSeeder::class,
            BadgeSeeder::class,
            UserSeeder::class,
        ]);
        
        $lessons = Lesson::factory()
            ->count(20)
            ->create();
    }
}
