<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AchievementService;
use App\Services\BadgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AchievementsController extends Controller
{
    /**
     * cache result for 30 days if no changes are made.
     * Inject badge and achievement services.
     * 
     */
    public function index(User $user)
    {
        return Cache::remember('customer_achievements_'.$user->id, 60 * 60 * 24 * 30, function () use ($user) {
            return response()->json([
                'unlocked_achievements' => (new AchievementService)->unlocked_achievements($user),
                'next_available_achievements' => (new AchievementService)->next_available_achievements($user),
                'current_badge' => (new BadgeService)->current_badge($user) ? (new BadgeService)->current_badge($user)->name : '',
                'next_badge' => (new BadgeService)->next_badge($user) ? (new BadgeService)->next_badge($user)->name : '',
                'remaining_to_unlock_next_badge' => (new BadgeService)->remaining_to_unlock_next_badge($user)
            ]);
        });
    }
}
