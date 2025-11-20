<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompetitionCsvUploadRequest;
use App\Services\CompetitionCsvService;
use Illuminate\Http\RedirectResponse;

class CompetitionCsvController extends Controller
{
    public function __construct(private CompetitionCsvService $service)
    {
    }

    /**
     * アップロードフォーム表示
     */
    public function showForm()
    {
        return view('competitions.upload');
    }

    /**
     * CSVアップロード処理
     */
    public function upload(CompetitionCsvUploadRequest $request): RedirectResponse
    {
        $filePath = $request->file('csv')->store('uploads');

        try {
            $count = $this->service->import(storage_path("app/{$filePath}"));

            return redirect()
                ->back()
                ->with('success', "CSVの取り込みに成功しました（{$count}件）");

        } catch (\Throwable $e) {

            return redirect()
                ->back()
                ->with('error', "CSV取り込みエラー: " . $e->getMessage());
        }
    }
}
