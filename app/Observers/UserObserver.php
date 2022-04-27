<?php

namespace App\Observers;

use App\Models\User;
use App\Events\BadgeUnlocked;
use Illuminate\Support\Facades\Cache;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //fire event to add beginner badge to customer when created
        event(new BadgeUnlocked('Beginner', $user));

    }

}
