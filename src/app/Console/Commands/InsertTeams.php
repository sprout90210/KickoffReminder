<?php

namespace App\Console\Commands;

use App\Models\Team;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InsertTeams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:insertTeams';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inseert teams from external API';

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
                $res = $client->get("competitions/{$competition_id}/teams");
                $res_json = json_decode($res->getBody());
                $teams = $res_json->teams;
                foreach ($teams as $team) {
                    Team::firstOrCreate(['id' => $team->id], [
                        'id' => $team->id,
                        'name' => $team->name,
                        'short_name' => $team->shortName,
                        'crest' => null,
                        'venue' => $team->venue,
                        'website_url' => null,
                        'twitter_url' => null,
                        'youtube_url' => null,
                        'instagram_url' => null,
                    ]);
                }
            } catch (GuzzleException $e) {
                $this->error('リクエストに失敗しました: '.$e->getMessage());
                Log::error('insertTeams failed', [
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $hasErrors = true;
            }
        }

        return $hasErrors ? 1 : 0;
    }
}
