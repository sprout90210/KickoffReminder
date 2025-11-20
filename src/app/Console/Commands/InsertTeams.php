<?php

namespace App\Console\Commands;

use App\Enums\CommandStatus;
use App\Services\InsertTeamsService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InsertTeams extends Command
{
    protected $signature = 'command:insertTeams';
    protected $description = 'Insert teams from external API';

    private InsertTeamsService $service;

    public function __construct(InsertTeamsService $service)
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
        $this->info('InsertTeams: Start inserting teams...');

        try {
            $hasErrors = $this->service->insertAllCompetitionsTeams();

            if ($hasErrors) {
                $this->warn("InsertTeams: Completed with some errors.");
                return CommandStatus::PARTIAL_FAILURE->code();
            }

            $this->info('InsertTeams: All teams inserted successfully!');
            return CommandStatus::SUCCESS->code();

        } catch (\Throwable $e) {
            $this->error('InsertTeams: Unexpected error occurred.');
            Log::critical('InsertTeams Fatal Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return CommandStatus::FAILURE->code();
        }
    }
}
