<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $achievements = [

            //lesson achievements
            [
                'name' => 'First Lesson Watched',
                'value' => 1
            ],
            [
                'name' => '5 Lessons Watched',
                'value' => 5
            ],
            [
                'name' => '10 Lessons Watched',
                'value' => 10
            ],
            [
                'name' => '25 Lessons Watched',
                'value' => 25
            ],
            [
                'name' => '50 Lessons Watched',
                'value' => 50
            ],

            //comments achievements
            [
                'name' => 'First Comment Written',
                'type' => 'comment_written',
                'value' => 1
            ],
            [
                'name' => '3 Comments Written',
                'type' => 'comment_written',
                'value' => 3
            ],
            [
                'name' => '5 Comments Written',
                'type' => 'comment_written',
                'value' => 5
            ],
            [
                'name' => '10 Comments Written',
                'type' => 'comment_written',
                'value' => 10
            ],
            [
                'name' => '20 Comments Written',
                'type' => 'comment_written',
                'value' => 20
            ],
            
        ];
        
        foreach ($achievements as $achievement ) {
            Achievement::updateOrCreate($achievement);
        }
    }
}
