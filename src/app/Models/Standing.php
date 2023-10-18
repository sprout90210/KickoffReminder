<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }

    public function season()
    {
        return $this->belongsTo(Season::class);
    }

}
