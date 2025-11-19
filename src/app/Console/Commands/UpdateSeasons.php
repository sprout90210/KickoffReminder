<?php

namespace App\Console\Commands;

use App\Enums\CommandStatus;
use App\Services\UpdateSeasonsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateSeasons extends Command
{
    protected $signature = 'command:updateSeasons';
    protected $description = 'Update seasons from external API';

    private UpdateSeasonsService $service;

    public function __construct(UpdateSeasonsService $service)
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
        $this->info("UpdateSeasons: Start updating seasons...");
        
        try {
            $hasErrors = $this->service->update();

            if ($hasErrors) {
                $this->warn("UpdateSeasons: Completed with some errors.");
                return CommandStatus::PARTIAL_FAILURE->code();
            }

            $this->info("UpdateSeasons: All seasons updated successfully!");
            return CommandStatus::SUCCESS->code();

        } catch (\Throwable $e) {
            $this->error("UpdateSeasons: Unexpected error occurred.");
            Log::critical("UpdateSeasons: Fatal Error", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return CommandStatus::FAILURE->code();
        }
    }
}
