<?php

namespace App\Console\Commands;

use App\Models\Game;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateGames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateGames';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update games from external API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $token = config('services.api.X_AUTH_TOKEN');
        $client = new Client([
            'base_uri' => 'http://api.football-data.org/v4/',
            'headers' => [
                'X-Auth-Token' => $token,
            ],
        ]);
        $hasErrors = false;
        $competition_ids = [2001, 2002, 2014, 2015, 2019, 2021];

        foreach ($competition_ids as $competition_id) {
            try {
                $res = $client->get("competitions/{$competition_id}/matches");
                $games = json_decode($res->getBody())->matches;
                $bulkData = [];
                foreach ($games as $game) {
                    $bulkData[] = [
                        'id' => $game->id,
                        'competition_id' => $game->competition->id,
                        'season_id' => $game->season->id,
                        'home_team_id' => $game->homeTeam->id,
                        'away_team_id' => $game->awayTeam->id,
                        'home_team_score' => $game->score->fullTime->home,
                        'away_team_score' => $game->score->fullTime->away,
                        'status' => $game->status,
                        'stage' => $game->stage,
                        'group' => $game->group,
                        'matchday' => $game->matchday,
                        'utc_date' => Carbon::parse($game->utcDate)->format('Y-m-d H:i:s'),
                        'last_updated' => Carbon::parse($game->lastUpdated)->format('Y-m-d H:i:s'),
                    ];
                }
                Game::upsert($bulkData, ['id'], ['competition_id', 'season_id', 'home_team_id', 'away_team_id', 'home_team_score', 'away_team_score', 'status', 'stage', 'group', 'matchday', 'utc_date', 'last_updated']);

            } catch (GuzzleException $e) {
                $this->error("Request failed for competition ID {$competition_id}: {$e->getMessage()}");
                Log::error('UpdateGames failed', [
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $hasErrors = true;
            }
        }

        return $hasErrors ? 1 : 0;
    }
}
