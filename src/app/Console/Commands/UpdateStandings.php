<?php

namespace App\Console\Commands;

use App\Enums\CommandStatus;
use App\Services\UpdateStandingsService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateStandings extends Command
{
    protected $signature   = 'command:updateStandings';
    protected $description = 'Update standings from external API';

    private UpdateStandingsService $service;

    public function __construct(UpdateStandingsService $service)
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
        $this->info("Start updating standings...");
        
        try {
            $hasErrors = $this->service->update();

            if ($hasErrors) {
                $this->warn("Completed with some errors.");
                return CommandStatus::PARTIAL_FAILURE->code();
            }

            $this->info("All standings updated successfully!");
            return CommandStatus::SUCCESS->code();

        } catch (\Throwable $e) {
            $this->error("Unexpected error occurred.");
            Log::critical("UpdateStandings Fatal Error", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return CommandStatus::FAILURE->code();
        }
    }
}
