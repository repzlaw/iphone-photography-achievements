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

    /**
     * get the next available achievements for the customer.
     */
    public function next_available_achievements(User $user)
    {
        $next_achievements = [];

        // Get watched lessons achievements
        $watched_lessons = $user->watched->count();

        $get_achievement = Achievement::where([
            'type'=>'lesson_watched',
            ['value', '>', $watched_lessons]])
            ->orderBy('value', 'asc')
            ->first();

        if ($get_achievement) {
            $next_achievements[] = $get_achievement->name;
        }

        // Get written comment achievements
        $written_comments = $user->comments->count();

        $get_achievement = Achievement::where([
            'type'=>'comment_written',
            ['value', '>', $written_comments]])
            ->orderBy('value', 'asc')
            ->first();

        if ($get_achievement) {
            $next_achievements[] = $get_achievement->name;
        }
        
        return $next_achievements;
    }
}