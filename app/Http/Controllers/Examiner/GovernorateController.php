<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Governorate;

class GovernorateController extends Controller
{
    public function areas(Governorate $governorate)
    {

        return view('teacher.governorates._areas', compact('governorate'));

    }// end of areas

}//end of controller
