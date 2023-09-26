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
                'competition_id' => 2021,
                'start_date' => "2023-08-11",
                'end_date' => "2024-05-19",
            ],
            [
                'id' => 733,
                'competition_id' => 2021,
                'start_date' => "2021-08-13",
                'end_date' => "2022-05-22",
            ],
            [
                'id' => 1490,
                'competition_id' => 2021,
                'start_date' => "2022-08-05",
                'end_date' => "2023-05-28",
            ],
            [
                'id' => 380,
                'competition_id' => 2014,
                'start_date' => "2021-08-13",
                'end_date' => "2022-05-22",
            ],
            [
                'id' => 1504,
                'competition_id' => 2014,
                'start_date' => "2022-08-14",
                'end_date' => "2023-06-04",
            ],
            [
                'id' => 746,
                'competition_id' => 2015,
                'start_date' => "2021-08-06",
                'end_date' => "2022-05-21",
            ],
            [
                'id' => 1497,
                'competition_id' => 2015,
                'start_date' => "2022-08-07",
                'end_date' => "2023-06-03",
            ],
            [
                'id' => 757,
                'competition_id' => 2019,
                'start_date' => "2021-08-21",
                'end_date' => "2022-05-22",
            ],
            [
                'id' => 1505,
                'competition_id' => 2019,
                'start_date' => "2022-08-14",
                'end_date' => "2023-06-04",
            ],
            [
                'id' => 742,
                'competition_id' => 2002,
                'start_date' => "2021-08-13",
                'end_date' => "2022-05-14",
            ],
            [
                'id' => 1495,
                'competition_id' => 2002,
                'start_date' => "2022-08-05",
                'end_date' => "2023-05-27",
            ],
        ]);
    }
}
