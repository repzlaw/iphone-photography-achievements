<?php

namespace App\Listeners;

use App\Models\Badge;
use App\Models\Achievement;
use App\Events\BadgeUnlocked;
use App\Events\AchievementUnlocked;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UnlockAchievement
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
     * @param  \App\Events\AchievementUnlocked  $event
     * @return void
     */
    public function handle(AchievementUnlocked $event)
    {
        //get achievement
        $achievement = Achievement::where('name', $event->achievement_name)->first();

        //check if achievement exists
        if(! $achievement){
            return ;
        }

        //forget the cached achievement for this customer
        Cache::forget('customer_achievements_'.$event->user->id);

        //add the achievement to user achievements table
        $event->user->achievements()->syncWithoutDetaching($achievement->id);

        //get users badge
        $badge = Badge::where('value', '<=', $event->user->achievements->count() )
                        ->orderBy('value','desc')
                        ->first();

        //check if badge exist and fire badge unlocked event                
        if ($badge) {
            event(new BadgeUnlocked($badge->name, $event->user));
        }

    }
}
