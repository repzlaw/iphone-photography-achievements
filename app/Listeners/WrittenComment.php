<?php

namespace App\Listeners;

use App\Models\Achievement;
use App\Events\CommentWritten;
use App\Events\AchievementUnlocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class WrittenComment
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
     * @param  \App\Events\CommentWritten  $event
     * @return void
     */
    public function handle(CommentWritten $event)
    {
        //get comments
        $comment_count = $event->comment->user->refresh()->comments->count();

        //get achievement based on the comment count
        $achievement = Achievement::where(['type'=> 'comment_written', 'value'=> $comment_count])->first();
        
        //check if achievement exists and fire AchievementUnlocked event
        if ($achievement) {
            event(new AchievementUnlocked($achievement->name, $event->comment->user));
        }
    }
}
