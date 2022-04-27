<?php

namespace App\Models;

use App\Models\Achievement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AchievementUser extends Model
{
    use HasFactory;

    protected $table = 'achievement_user';

    protected $fillable = [
        'user_id',
        'achievement_id'
    ];

    /**
     * The achievement belogs to relationship.
     */
    public function achievement()
    {
        return $this->belongsTo(Achievement::class);
    }
}
