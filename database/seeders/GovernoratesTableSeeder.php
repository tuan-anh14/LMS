<?php

namespace Database\Seeders;

use App\Models\Governorate;
use Illuminate\Database\Seeder;

class GovernoratesTableSeeder extends Seeder
{
    public function run(): void
    {
        $governorates = [
            ['name' => 'اسطنبول', 'country_id' => 1],
        ];

        foreach ($governorates as $governorate) {

            Governorate::create($governorate);

        }//end of for each

    }//end of run

}//end of seeder
