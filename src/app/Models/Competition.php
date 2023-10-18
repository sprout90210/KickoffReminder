<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Season;
use App\Models\Standing;


class Competition extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'current_season_id',
        'name',
        'code',
        'competition_type',
        'embleme',
    ];

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }

    public function standings()
    {
        return $this->hasMany(Standing::class);
    }

    public function games()
    {
        return $this->hasMany(Game::class);
    }


    public static function getCurrentStandings($competitionId){

        $currentSeasonId = Season::where('competition_id', $competitionId)
            ->latest('start_date')
            ->value('id');

        $standings = Standing::with('team')
            ->where('season_id', $currentSeasonId)
            ->orderBy('position', 'asc')
            ->get();

        return $standings;
    }


    public static function getResults($competitionId){

        $results = Game::where('competition_id', $competitionId)
            ->whereIn('status', ['FINISHED', 'IN_PLAY'])
            ->orderBy('utc_date', 'desc')
            ->with(['homeTeam','awayTeam','competition'])
            ->limit(50)
            ->get();

        return $results;
    }


    public static function getSchedules($competitionId){

        $schedules = Game::where('competition_id', $competitionId)
            ->where('status', 'TIMED')
            ->orderBy('utc_date', 'asc')
            ->with(['homeTeam','awayTeam','competition'])
            ->limit(50)
            ->get();

        return $schedules;
    }




}
