<?php

namespace App\Listeners;

use App\Models\Badge;
use App\Events\BadgeUnlocked;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnlockBadge
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\BadgeUnlocked  $event
     * @return void
     */
    public function handle(BadgeUnlocked $event)
    {
        //get badge details
        $badge = Badge::where('name', $event->badge_name)->firstOrFail();

        //add batch to user batches table for the customer
        $event->user->badges()->syncWithoutDetaching($badge->id);

        //forget cache if present
        Cache::forget('customer_achievements_'.$event->user->id);
    }
}
