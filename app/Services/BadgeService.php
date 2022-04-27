<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;

class BadgeService{

    /**
     * The customers current badge.
     */
    public function current_badge(User $user)
    {
        $current_badge =  $user->badges->sortByDesc('value')->first();

        return $current_badge;
    }


}