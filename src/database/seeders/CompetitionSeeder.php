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
                'id' => 2021,
                'name' => 'プレミアリーグ',
                'code' => 'PL',
                'current_season_id' => 1564,
                'emblem' => 'PL.png',
            ],
            [
                'id' => 2014,
                'name' => 'リーガエスパニョーラ',
                'code' => 'PD',
                'current_season_id' => 1,
                'emblem' => 'PD.png',
            ],
            [
                'id' => 2002,
                'name' => 'ブンデスリーガ',
                'code' => 'BL1',
                'current_season_id' => 11,
                'emblem' => 'BL1.png',
            ],

            [
                'id' => 2019,
                'name' => 'セリエA',
                'code' => 'SA',
                'current_season_id' => 733,
                'emblem' => 'SA.png',
            ],
            [
                'id' => 2015,
                'name' => 'リーグアン',
                'code' => 'FL1',
                'current_season_id' => 22,
                'emblem' => 'FL1.png',
            ],
        ]);
    }
}
