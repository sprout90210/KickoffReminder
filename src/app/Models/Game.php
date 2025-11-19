<?php

namespace App\Models;

use App\Enums\GameStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'competition_id',
        'season_id',
        'home_team_id',
        'away_team_id',
        'home_team_score',
        'away_team_score',
        'status',
        'stage',
        'group',
        'matchday',
        'utc_date',
        'last_updated',
    ];

    protected $casts = [
        'status' => GameStatus::class,
    ];


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

    /**
     * @return BelongsTo<\App\Models\Team, self>
     */
    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    /**
     * @return BelongsTo<\App\Models\Team, self>
     */
    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}
