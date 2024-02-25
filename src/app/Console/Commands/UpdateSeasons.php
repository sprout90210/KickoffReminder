<?php

namespace App\Console\Commands;

use App\Models\Season;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateSeasons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updateSeasons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update seasons from external API';

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
                $res = $client->get("competitions/{$competition_id}");
                $res_json = json_decode($res->getBody());
                $seasons = $res_json->seasons;
                $bulkData = [];
                foreach ($seasons as $season) {
                    $bulkData[] = [
                        'id' => $season->id,
                        'competition_id' => $res_json->id,
                        'start_date' => $season->startDate,
                        'end_date' => $season->endDate,
                    ];
                }
                Season::upsert($bulkData, ['id'], ['competition_id', 'start_date', 'end_date']);

            } catch (GuzzleException $e) {
                $this->error('リクエストに失敗しました: '.$e->getMessage());
                Log::error('UpdateSeasons failed', [
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $hasErrors = true;
            }
        }

        return $hasErrors ? 1 : 0;
    }
}
