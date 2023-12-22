<?php

namespace App\Console\Commands;

use App\Models\Game;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

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

        $competition_ids = [2014, 2021, 2015, 2002, 2019, 2001];

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
                        'utc_date' => Carbon::parse($game->utcDate)->format('Y-m-d H:i:s'),
                        'last_updated' => Carbon::parse($game->lastUpdated)->format('Y-m-d H:i:s'),
                    ];
                }
                Game::upsert($bulkData, ['id'], ['competition_id', 'season_id', 'home_team_id', 'away_team_id', 'home_team_score', 'away_team_score', 'status', 'stage', 'group', 'utc_date', 'last_updated']);

                return 0;

            } catch (\GuzzleHttp\Exception\GuzzleException $e) {
                $this->error('リクエストに失敗しました: '.$e->getMessage());
                return 1;
            }
        }
    }
}
