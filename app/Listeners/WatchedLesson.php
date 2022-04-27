<?php

namespace App\Listeners;

use App\Models\Lesson;
use App\Models\LessonUser;
use App\Models\Achievement;
use App\Events\LessonWatched;
use App\Events\AchievementUnlocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WatchedLesson
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
     * @param  \App\Events\LessonWatched  $event
     * @return void
     */
    public function handle(LessonWatched $event)
    {
        //create or update watched lesson status to true
        $lesson = LessonUser::firstOrNew([
            'lesson_id' => $event->lesson->id,
            'user_id' => $event->user->id,
        ]);
        $lesson->watched = true;
        $lesson->save();

        //get watched lessons count for a customer
        $lesson_count = $event->user->refresh()->watched->count();

        //get achievement based on the lesson count
        $achievement = Achievement::where(['type'=> 'lesson_watched', 'value'=> $lesson_count])->first();

        //check if achievement exists and fire Achievement Unlocked event
        if ($achievement) {
            event(new AchievementUnlocked($achievement->name, $event->user));
        }
    }
}
