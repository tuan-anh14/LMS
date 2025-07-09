<?php

namespace Database\Seeders;

use App\Models\Center;
use Illuminate\Database\Seeder;

class CentersTableSeeder extends Seeder
{
    public function run(): void
    {
        $centers = [
            [
                'id' => 1,
                'name' => 'Khoá K1',
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:05:24',
            ],
            [
                'id' => 2,
                'name' => 'Khoá K2',
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:05:33',
            ],
            [
                'id' => 3,
                'name' => 'Khoá K3',
                'created_at' => '2025-07-05 08:18:06',
                'updated_at' => '2025-07-09 15:05:41',
            ],
        ];

        foreach ($centers as $center) {
            \App\Models\Center::create($center);
        }

    }//end of run

}//end of seeder
