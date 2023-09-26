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
        'name',
        'code',
        'current_season_id',
        'embleme',
    ];

    public function seasons()
    {
        return $this->hasMany(Season::class);
    }


    public static function getCurrentStandings($competitionId){

        // $competitionId = (int) preg_replace('/[^0-9]/', '', $competitionId);
        $currentSeasonId = Season::where('competition_id', $competitionId)
            ->latest('start_date')
            ->value('id');

        if ($currentSeasonId) {

            $standings = Standing::with('team')
                ->where('season_id', $currentSeasonId)
                ->orderBy('position', 'asc')
                ->get();

            return response()->json($standings);

        } else {

            return response()->json(['message' => 'No standings found for the current season'], 404);

        }

    }




}
