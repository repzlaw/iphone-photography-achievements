<?php

namespace App\Services;

use App\Models\Achievement;
use App\Models\User;

class AchievementService{

    /**
     * The achievements customer has unlocked.
     */
    public function unlocked_achievements(User $user)
    {
        $unlocked_achievements = $user->achievements->pluck('name', 'name')->keys();
        
        return $unlocked_achievements;
    }

}