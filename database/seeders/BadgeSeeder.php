<?php

namespace Database\Seeders;

use App\Models\Badge;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $badges = [
            [
                'name' => 'Beginner',
                'value' => 0
            ],
            [
                'name' => 'Intermediate',
                'value' => 4
            ],
            [
                'name' => 'Advanced',
                'value' => 8
            ],
            [
                'name' => 'Master',
                'value' => 10
            ],
        ];

        foreach ($badges as $badge) {
            Badge::updateOrCreate($badge);
        }
    }
}
