<?php

namespace App\Console\Commands;

use App\Enums\CommandStatus;
use App\Services\UpdateGamesService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateGames extends Command
{
    protected $signature = 'command:updateGames';
    protected $description = 'Update games from external API';

    private UpdateGamesService $service;

    public function __construct(UpdateGamesService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info("UpdateGames: Start updating games...");
        
        try {
            $hasErrors = $this->service->update();

            if ($hasErrors) {
                $this->warn("UpdateGames: Completed with some errors.");
                return CommandStatus::PARTIAL_FAILURE->code();
            }

            $this->info("UpdateGames: All games updated successfully!");
            return CommandStatus::SUCCESS->code();

        } catch (\Throwable $e) {
            $this->error("UpdateGames: Unexpected error.");
            Log::critical("UpdateGames: UpdateGames Fatal Error", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return CommandStatus::FAILURE->code();
        }
    }
}
