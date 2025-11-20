<?php

namespace App\Services;

use App\Models\Competition;
use Illuminate\Support\Facades\Log;

class CompetitionCsvService
{
    /**
     * CSV ファイルを読み込み competitions に保存
     *
     * @param string $filepath
     * @return int 取り込んだ件数
     */
    public function import(string $filepath): int
    {
        if (!file_exists($filepath)) {
            throw new \RuntimeException("CSVファイルが存在しません: {$filepath}");
        }

        $handle = fopen($filepath, 'r');
        if (!$handle) {
            throw new \RuntimeException("CSVを開けません: {$filepath}");
        }

        // 1行目ヘッダを読み飛ばす
        $header = fgetcsv($handle);

        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            try {
                // 列は CSV 仕様に合わせる
                Competition::updateOrCreate(
                    ['id' => $row[0]], // 主キー or unique の列
                    [
                        'name'               => $row[1],
                        'code'               => $row[2],
                        'competition_type'   => $row[3],
                        'emblem'             => $row[4] ?: null,
                        'current_season_id'  => $row[5] ?: null,
                    ]
                );
                $imported++;

            } catch (\Throwable $e) {
                Log::error('Competition CSV row error', [
                    'row' => $row,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        fclose($handle);

        return $imported;
    }
}
