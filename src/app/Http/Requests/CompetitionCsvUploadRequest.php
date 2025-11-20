<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompetitionCsvUploadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'csv' => [
                'required',
                'file',
                'mimetypes:text/csv',
                'max:10240', // 10MB
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'csv.required' => 'CSVファイルを選択してください。',
            'csv.mimetypes' => 'CSVファイルのみアップロードできます。',
            'csv.max' => 'ファイルサイズが大きすぎます。',
        ];
    }
}
