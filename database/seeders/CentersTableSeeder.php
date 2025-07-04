<?php

namespace Database\Seeders;

use App\Models\Center;
use Illuminate\Database\Seeder;

class CentersTableSeeder extends Seeder
{
    public function run(): void
    {
        $centers = [
            ['name' => 'Trung tâm 1',],

            ['name' => 'Trung tâm 2',],

            ['name' => 'Trung tâm 3',],
        ];

        foreach ($centers as $center) {

            Center::create($center);

        }//end of foreach

    }//end of run

}//end of seeder
