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
                'id' => 734,
                'competition_id' => 2001,
                'start_date' => "2021-06-22",
                'end_date' => "2022-05-28",
            ],
            [
                'id' => 1491,
                'competition_id' => 2001,
                'start_date' => "2022-06-21",
                'end_date' => "2023-06-10",
            ],
            [
                'id' => 1630,
                'competition_id' => 2001,
                'start_date' => "2023-09-19",
                'end_date' => "2024-06-01",
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
                'id' => 1564,
                'competition_id' => 2021,
                'start_date' => "2023-08-11",
                'end_date' => "2024-05-29",
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
                'id' => 1577,
                'competition_id' => 2014,
                'start_date' => "2023-08-13",
                'end_date' => "2024-05-26",
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
                'id' => 1592,
                'competition_id' => 2015,
                'start_date' => "2023-08-18",
                'end_date' => "2023-05-18",
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
