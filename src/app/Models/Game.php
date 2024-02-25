<?php

namespace App\Models;

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

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public static function getReminders($teamIds)
    {
        return self::with(['homeTeam', 'awayTeam', 'competition'])
            ->where(function ($query) use ($teamIds) {
                $query->whereIn('home_team_id', $teamIds)
                    ->orWhereIn('away_team_id', $teamIds);
            })
            ->whereIn('status', ['SCHEDULED', 'TIMED'])
            ->orderBy('utc_date', 'asc')
            ->limit(30)
            ->get();
    }
}
