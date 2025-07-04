<?php

namespace Database\Seeders;

use App\Models\Degree;
use Illuminate\Database\Seeder;

class DegreesTableSeeder extends Seeder
{
    public function run(): void
    {
        $degrees = [
            ['name' => 'Cử nhân'],
            ['name' => 'Thạc sĩ'],
            ['name' => 'Tiến sĩ'],
        ];

        foreach ($degrees as $degree) {

            Degree::create($degree);

        }//end of for each

    }//end of run

}//end of seeder
