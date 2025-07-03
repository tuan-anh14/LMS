<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
{
    public function governorates(Country $country)
    {
        $governorates = $country->governorates;

        return view('teacher.countries._governorates', compact('governorates', 'country'));

    }// end of governorates

}//end of controller
