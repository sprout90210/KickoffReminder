<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonSeeder extends Seeder
{
    public function run()
    {
        DB::table('seasons')->insert([
            // チャンピオンズリーグ
            [
                'id' => 1630,
                'competition_id' => 2001,
                'start_date' => '2023-09-19',
                'end_date' => '2024-06-01',
            ],

            // プレミアリーグ
            [
                'id' => 1564,
                'competition_id' => 2021,
                'start_date' => '2023-08-11',
                'end_date' => '2024-05-29',
            ],

            // ラ・リーガ
            [
                'id' => 1577,
                'competition_id' => 2014,
                'start_date' => '2023-08-13',
                'end_date' => '2024-05-26',
            ],

            // リーグアン
            [
                'id' => 1595,
                'competition_id' => 2015,
                'start_date' => '2023-08-13',
                'end_date' => '2024-05-18',
            ],

            // セリエ
            [
                'id' => 1600,
                'competition_id' => 2019,
                'start_date' => '2023-08-19',
                'end_date' => '2024-05-26',
            ],

            // ブンデスリーガ
            [
                'id' => 1592,
                'competition_id' => 2002,
                'start_date' => '2023-08-18',
                'end_date' => '2024-05-18',
            ],
        ]);
    }
}
