<?php

namespace Database\Seeders;

use App\Models\Degree;
use Illuminate\Database\Seeder;

class DegreesTableSeeder extends Seeder
{
    public function run(): void
    {
        $degrees = [
            ['name' => 'بكالوريوس'],
            ['name' => 'ماجستير'],
            ['name' => 'دكتوراه'],
        ];

        foreach ($degrees as $degree) {

            Degree::create($degree);

        }//end of for each

    }//end of run

}//end of seeder
