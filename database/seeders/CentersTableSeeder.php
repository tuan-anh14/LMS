<?php

namespace Database\Seeders;

use App\Models\Center;
use Illuminate\Database\Seeder;

class CentersTableSeeder extends Seeder
{
    public function run(): void
    {
        $centers = [
            ['name' => 'مركز 1',],

            ['name' => 'مركز 2',],

            ['name' => 'مركز 3',],
        ];

        foreach ($centers as $center) {

            Center::create($center);

        }//end of foreach

    }//end of run

}//end of seeder
