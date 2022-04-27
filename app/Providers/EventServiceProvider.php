<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Comment;
use App\Events\BadgeUnlocked;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Listeners\UnlockBadge;
use App\Observers\UserObserver;
use App\Listeners\WatchedLesson;
use App\Listeners\WrittenComment;
use App\Observers\CommentObserver;
use App\Events\AchievementUnlocked;
use App\Listeners\UnlockAchievement;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CommentWritten::class => [
            WrittenComment::class
        ],
        LessonWatched::class => [
            WatchedLesson::class
        ],
        AchievementUnlocked::class => [
            UnlockAchievement::class
        ],
        BadgeUnlocked::class => [
            UnlockBadge::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Comment::observe(CommentObserver::class);
    }
}
