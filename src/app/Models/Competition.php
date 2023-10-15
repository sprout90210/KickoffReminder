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




}
