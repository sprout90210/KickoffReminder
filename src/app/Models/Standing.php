<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Standing extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'competition_id',
        'season_id',
        'team_id',
        'position',
        'played_games',
        'won',
        'draw',
        'lost',
        'goals_for',
        'goals_against',
        'goal_difference',
        'points',
    ];

    /**
     * @return BelongsTo<\App\Models\Team, self>
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * @return BelongsTo<\App\Models\Competition, self>
     */
    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    /**
     * @return BelongsTo<\App\Models\Season, self>
     */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }
}
