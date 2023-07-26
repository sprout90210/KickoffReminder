<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeasonSeeder extends Seeder
{
    public function run()
    {
        DB::table('seasons')->insert([
            [
                'id' => 1564,
                'start_date' => "2023-08-11",
                'end_date' => "2024-05-19",
                'competition_id' => 2021,
            ],
            [
                'id' => 733,
                'start_date' => "2021-08-13",
                'end_date' => "2022-05-22",
                'competition_id' => 2021,
            ],
            [
                'id' => 1490,
                'start_date' => "2022-08-05",
                'end_date' => "2023-05-28",
                'competition_id' => 2021,
            ],
            [
                'id' => 380,
                'start_date' => "2021-08-13",
                'end_date' => "2022-05-22",
                'competition_id' => 2014,
            ],
            [
                'id' => 1504,
                'start_date' => "2022-08-14",
                'end_date' => "2023-06-04",
                'competition_id' => 2014,
            ],
            [
                'id' => 746,
                'start_date' => "2021-08-06",
                'end_date' => "2022-05-21",
                'competition_id' => 2015,
            ],
            [
                'id' => 1497,
                'start_date' => "2022-08-07",
                'end_date' => "2023-06-03",
                'competition_id' => 2015,
            ],
            [
                'id' => 757,
                'start_date' => "2021-08-21",
                'end_date' => "2022-05-22",
                'competition_id' => 2019,
            ],
            [
                'id' => 1505,
                'start_date' => "2022-08-14",
                'end_date' => "2023-06-04",
                'competition_id' => 2019,
            ],
            [
                'id' => 742,
                'start_date' => "2021-08-13",
                'end_date' => "2022-05-14",
                'competition_id' => 2002,
            ],
            [
                'id' => 1495,
                'start_date' => "2022-08-05",
                'end_date' => "2023-05-27",
                'competition_id' => 2002,
            ],
        ]);
    }
}
