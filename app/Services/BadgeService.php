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

    /**
     * The customers next badge.
     */
    public function next_badge(User $user)
    {
        $current_badge =  $this->current_badge($user);

        $next_badge =  Badge::where('value', '>', $current_badge->value)
                            ->orderBy('value','asc')->first();

        return $next_badge ? $next_badge : '';

    }


}