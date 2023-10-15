<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Standing;


class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'short_name',
        'crest',
        'venue',
        'website_url',
        'twitter_url',
        'youtube_url',
        'insatgram_url',
    ];


    public static function getStandings($teamId){

        $competitionId = Standing::join('seasons','standings.season_id','=','seasons.id')
            ->where('team_id', $teamId)
            ->orderBy('seasons.start_date', 'desc')
            ->value('competition_id');

        $teamStandings = Competition::getCurrentStandings($competitionId);

        return $teamStandings;
    }


    public static function getResults($teamId){

        $results = Game::where(function($query) use ($teamId) {
                $query->where('home_team_id', $teamId)
                ->orWhere('away_team_id', $teamId);
            })
            ->where('status', 'FINISHED')
            ->orWhere('status', 'IN_PLAY')
            ->orderBy('utc_date', 'desc')
            ->with(['homeTeam','awayTeam','competition'])
            ->limit(50)
            ->get();

        return $results;
    }


    public static function getSchedules($teamId){

        $schedules = Game::where(function($query) use ($teamId) {
                $query->where('home_team_id', $teamId)
                ->orWhere('away_team_id', $teamId);
            })
            ->where('status', 'TIMED')
            ->orderBy('utc_date', 'asc')
            ->with(['homeTeam','awayTeam','competition'])
            ->limit(50)
            ->get();

        return $schedules;
    }


    public static function getNextGame($teamId){

        $nextGame = Game::where(function($query) use ($teamId) {
                $query->where('home_team_id', $teamId)
                ->orWhere('away_team_id', $teamId);
            })
            ->where('status', 'TIMED')
            ->orWhere('status', 'IN_PLAY')
            ->orderBy('utc_date', 'asc')
            ->with(['homeTeam','awayTeam','competition'])
            ->first();

        return $nextGame;
    }


}
