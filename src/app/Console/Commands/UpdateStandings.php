<?php

namespace App\Console\Commands;

use App\Models\Standing;
use GuzzleHttp\Client;
use \GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateStandings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateStandings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update standings from external API';

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
        $competition_ids = [2002, 2014, 2015, 2019, 2021];

        foreach ($competition_ids as $competition_id) {
            try {
                $res = $client->get("competitions/{$competition_id}/standings");
                $res_json = json_decode($res->getBody());
                $standings = $res_json->standings[0]->table;
                $bulkData = [];
                foreach ($standings as $standing) {
                    $bulkData[] = [
                        'season_id' => $res_json->season->id,
                        'position' => $standing->position,
                        'competition_id' => $competition_id,
                        'team_id' => $standing->team->id,
                        'played_games' => $standing->playedGames,
                        'won' => $standing->won,
                        'draw' => $standing->draw,
                        'lost' => $standing->lost,
                        'goals_for' => $standing->goalsFor,
                        'goals_against' => $standing->goalsAgainst,
                        'goal_difference' => $standing->goalDifference,
                        'points' => $standing->points,
                    ];
                }
                Standing::upsert($bulkData, ['season_id', 'team_id'], ['competition_id', 'position', 'played_games', 'won', 'draw', 'lost', 'goals_for', 'goals_against', 'goal_difference', 'points']);

            } catch (GuzzleException $e) {
                $this->error('リクエストに失敗しました: '.$e->getMessage());
                Log::error('UpdateStandings failed', [
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $hasErrors = true;
            }
        }
        
        return $hasErrors ? 1 : 0;
    }
}
