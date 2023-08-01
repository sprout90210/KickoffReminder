<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Standing extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'position',
        'played_games',
        'won',
        'draw',
        'lost',
        'goals_for',
        'goals_against',
        'goal_difference',
        'points',
        'team_id',
        'season_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
    
}
