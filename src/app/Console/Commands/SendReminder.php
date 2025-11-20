<?php

namespace App\Console\Commands;

use App\Enums\CommandStatus;
use App\Services\SendReminderService;
use Illuminate\Console\Command;

/**
 * お気に入りチームの試合開始前にリマインダー通知を送信するコンソールコマンド.
 *
 * 指定された分前（1, 15, 60, 180, 360）の試合を取得し、
 * LINE または Email で対象ユーザーへ通知を送信する。
 */
class SendReminder extends Command
{
    private SendReminderService $sendReminderService;

    public function __construct(SendReminderService $sendReminderService)
    {
        parent::__construct();
        $this->sendReminderService = $sendReminderService;
    }

    /**
     * @var string Artisan コマンド名
     */
    protected $signature = 'command:sendReminder';

    /**
     * @var string コマンドの説明
     */
    protected $description = 'Send reminder for users favorite team games';

    /**
     * @var bool 通知処理中にエラーが発生したかどうか
     */
    protected bool $hasErrors = false;

    /**
     * リマインダー通知処理のメインロジック
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info("SendReminderService: Start sending reminders...");

        $hasErrors = $this->sendReminderService->execute();

        if ($hasErrors) {
            $this->warn("SendReminderService: Completed with errors.");
            return CommandStatus::PARTIAL_FAILURE->code();
        }

        $this->info("SendReminderService: All reminders processed successfully!");
        return CommandStatus::SUCCESS->code();
    }

}
