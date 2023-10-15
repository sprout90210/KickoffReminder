<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'utc_date',
    ];

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }
}
