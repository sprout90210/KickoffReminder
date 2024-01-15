<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompetitionSeeder extends Seeder
{
    public function run()
    {
        DB::table('competitions')->insert([
            [
                'id' => 2001,
                'current_season_id' => 1630,
                'name' => 'チャンピオンズリーグ',
                'code' => 'CL',
                'competition_type' => 'CUP',
                'emblem' => '2001.png',
            ],
            [
                'id' => 2002,
                'current_season_id' => 11,
                'name' => 'ブンデスリーガ',
                'code' => 'BL1',
                'competition_type' => 'LEAGUE',
                'emblem' => '2002.png',
            ],
            [
                'id' => 2014,
                'current_season_id' => 1,
                'name' => 'リーガエスパニョーラ',
                'code' => 'PD',
                'competition_type' => 'LEAGUE',
                'emblem' => '2014.png',
            ],
            [
                'id' => 2015,
                'current_season_id' => 22,
                'name' => 'リーグアン',
                'code' => 'FL1',
                'competition_type' => 'LEAGUE',
                'emblem' => '2015.png',
            ],
            [
                'id' => 2019,
                'current_season_id' => 733,
                'name' => 'セリエA',
                'code' => 'SA',
                'competition_type' => 'LEAGUE',
                'emblem' => '2019.png',
            ],
            [
                'id' => 2021,
                'current_season_id' => 1564,
                'name' => 'プレミアリーグ',
                'code' => 'PL',
                'competition_type' => 'LEAGUE',
                'emblem' => '2021.png',
            ],
        ]);
    }
}
