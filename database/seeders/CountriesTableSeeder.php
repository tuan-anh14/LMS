<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['name' => 'Việt Nam',]
        ];

        foreach ($countries as $country) {

            Country::create($country);

        }//end of for each

    }//end of run

}//end of seeder
