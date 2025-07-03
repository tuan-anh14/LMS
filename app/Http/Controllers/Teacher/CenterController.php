<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Center;

class CenterController extends Controller
{
    public function projects(Center $center)
    {
        $projects = $center->projects;

        return view('teacher.centers._projects', compact('projects', 'center'));

    }// end of projects

}//end of controller
