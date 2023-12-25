<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competition extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'current_season_id',
        'name',
        'code',
        'competition_type',
        'embleme',
    ];

    public function seasons(): HasMany
    {
        return $this->hasMany(Season::class);
    }

    public function standings(): HasMany
    {
        return $this->hasMany(Standing::class);
    }

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    public static function getCurrentStandings($competitionId)
    {
        $currentSeasonId = Season::where('competition_id', $competitionId)
            ->latest('start_date')
            ->value('id');

        $standings = Standing::with('team')
            ->where('season_id', $currentSeasonId)
            ->orderBy('position', 'asc')
            ->get();

        return $standings;
    }

    public static function getResults($competitionId)
    {
        $results = Game::where('competition_id', $competitionId)
            ->whereIn('status', ['FINISHED', 'IN_PLAY'])
            ->orderBy('utc_date', 'desc')
            ->with(['homeTeam', 'awayTeam', 'competition'])
            ->limit(50)
            ->get();

        return $results;
    }

    public static function getSchedules($competitionId)
    {
        $schedules = Game::where('competition_id', $competitionId)
            ->whereIn('status', ['TIMED', 'SCHEDULED'])
            ->orderBy('utc_date', 'asc')
            ->with(['homeTeam', 'awayTeam', 'competition'])
            ->limit(50)
            ->get();

        return $schedules;
    }
}
