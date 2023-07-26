<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'season_id',
        'hometeam_id',
        'awayteam_id',
        'hometeam_score',
        'awayteam_score',
        'winner',
        'status',
        'kickoff_utc',
    ];
}
