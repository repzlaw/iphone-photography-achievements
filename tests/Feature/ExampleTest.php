<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use App\Models\Achievement;
use App\Events\LessonWatched;
use App\Events\CommentWritten;
use App\Models\AchievementUser;
use App\Services\AchievementService;
use App\Services\BadgeService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $user = User::factory()->create();
        
        $response = $this->get("/users/{$user->id}/achievements");

        $response->assertStatus(200);
    }

    //test first lesson watched
    public function test_first_lesson_watched()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        event(new LessonWatched($lesson, $user));
        $achievement = $user->achievements->first()->name;

        $this->assertEquals( $achievement, 'First Lesson Watched' );
    }

    //test 5 lesson watched
    public function test_5_lesson_watched()
    {
        $user = User::factory()->create();
        $lessons = Lesson::factory()->count(5)->create();
        foreach ($lessons as $key => $lesson) {
            event(new LessonWatched($lesson, $user));
        }
        $achievement = AchievementUser::where('user_id',$user->id)
                        ->with('achievement')
                        ->orderBy('id','desc')->first();
        $achievement = $achievement->achievement->name;

        $this->assertEquals( $achievement, '5 Lessons Watched' );
    }

    //test 10 lesson watched
    public function test_10_lesson_watched()
    {
        $user = User::factory()->create();
        $lessons = Lesson::factory()->count(10)->create();
        foreach ($lessons as $key => $lesson) {
            event(new LessonWatched($lesson, $user));
        }
        $achievement = AchievementUser::where('user_id',$user->id)
                        ->with('achievement')
                        ->orderBy('id','desc')->first();
        $achievement = $achievement->achievement->name;

        $this->assertEquals( $achievement, '10 Lessons Watched' );
    }

    //test 25 lesson watched
    public function test_25_lesson_watched()
    {
        $user = User::factory()->create();
        $lessons = Lesson::factory()->count(25)->create();
        foreach ($lessons as $key => $lesson) {
            event(new LessonWatched($lesson, $user));
        }
        $achievement = AchievementUser::where('user_id',$user->id)
                        ->with('achievement')
                        ->orderBy('id','desc')->first();
        $achievement = $achievement->achievement->name;

        $this->assertEquals( $achievement, '25 Lessons Watched' );
    }

    //test 50 lesson watched
    public function test_50_lesson_watched()
    {
        $user = User::factory()->create();
        $lessons = Lesson::factory()->count(50)->create();
        foreach ($lessons as $key => $lesson) {
            event(new LessonWatched($lesson, $user));
        }
        $achievement = AchievementUser::where('user_id',$user->id)
                        ->with('achievement')
                        ->orderBy('id','desc')->first();
        $achievement = $achievement->achievement->name;

        $this->assertEquals( $achievement, '50 Lessons Watched' );
    }

    //test first comment written
    public function test_first_comment_written()
    {
        $comment = Comment::factory()->create();
        event(new CommentWritten($comment));
        $user = User::findOrFail($comment->user_id);

        $achievement = $user->achievements->first()->name;

        $this->assertEquals( $achievement, 'First Comment Written' );
    }

    //test 3 comment written
    public function test_3_comment_written()
    {
        $comments = Comment::factory()->count(3)->create();
        $user  = User::factory()->create();

        foreach ($comments as $key => $comment) {
            $comment->update(['user_id'=> $user->id]);
        }

        $comment_count = $user->comments->count();
        $achievement = Achievement::where(['type' => 'comment_written', 'value'=> $comment_count])->first();

        $this->assertEquals( $achievement->name, '3 Comments Written' );
    }

    //test 5 comment written
    public function test_5_comment_written()
    {
        $comments = Comment::factory()->count(5)->create();
        $user  = User::factory()->create();

        foreach ($comments as $key => $comment) {
            $comment->update(['user_id'=> $user->id]);
        }

        $comment_count = $user->comments->count();
        $achievement = Achievement::where(['type' => 'comment_written', 'value'=> $comment_count])->first();

        $this->assertEquals( $achievement->name, '5 Comments Written' );
    }

    //test 10 comment written
    public function test_10_comment_written()
    {
        $comments = Comment::factory()->count(10)->create();
        $user  = User::factory()->create();

        foreach ($comments as $key => $comment) {
            $comment->update(['user_id'=> $user->id]);
        }

        $comment_count = $user->comments->count();
        $achievement = Achievement::where(['type' => 'comment_written', 'value'=> $comment_count])->first();

        $this->assertEquals( $achievement->name, '10 Comments Written' );
    }

    //test 20 comment written
    public function test_20_comment_written()
    {
        $comments = Comment::factory()->count(20)->create();
        $user  = User::factory()->create();

        foreach ($comments as $key => $comment) {
            $comment->update(['user_id'=> $user->id]);
        }

        $comment_count = $user->comments->count();
        $achievement = Achievement::where(['type' => 'comment_written', 'value'=> $comment_count])->first();

        $this->assertEquals( $achievement->name, '20 Comments Written' );
    }

    //test unlocked achievements
    public function test_unlocked_achievements()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        event(new LessonWatched($lesson, $user));

        $achievements = [];
        foreach ($user->achievements as $achievement) {
            $achievements[]= $achievement->name;
        }

        $this->assertEquals( $achievements, (new AchievementService)->unlocked_achievements($user)->toArray() );
    }

    //test next available achievements
    public function test_next_available_achievements()
    {
        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        event(new LessonWatched($lesson, $user));

        $this->assertEquals( 'array', gettype((new AchievementService)->next_available_achievements($user)) );
    }

    //test current badge earned
    public function test_current_badge()
    {
        $user = User::factory()->create();

        $this->assertEquals( 'Beginner', (new BadgeService)->current_badge($user)->name );
    }

    //test next badge to be earned
    public function test_next_badge()
    {
        $user = User::factory()->create();

        $this->assertEquals( 'Intermediate', (new BadgeService)->next_badge($user)->name );
    }

    //test remaining achievements to unlock next badge 
    public function test_remaining_to_unlock_next_badge()
    {
        $user = User::factory()->create();
        $next_badge = (new BadgeService)->next_badge($user);
        if ($next_badge){
            $achievements = $user->achievements->count();
            $next_badge = $next_badge->value - $achievements;
        } else {
            $next_badge = 0;
        }

        $this->assertEquals( $next_badge, (new BadgeService)->remaining_to_unlock_next_badge($user) );
    }

}
