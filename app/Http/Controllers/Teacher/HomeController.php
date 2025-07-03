<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\StudentExamStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Center;

class HomeController extends Controller
{
    public function index()
    {
        $center = Center::query()
            ->withCount([
                'managers', 'teachers', 'students', 'projects', 'exams', 'sections', 'lectures'
            ])
            ->where('id', session('selected_center')['id'])
            ->first();


        $assignedStudentExamsCount = $center->exams()
            ->whenExaminerId(auth()->user()->id)
            ->whenStatus(StudentExamStatusEnum::ASSIGNED_TO_EXAMINER)
            ->count();

        return view('teacher.home',
            compact('center', 'assignedStudentExamsCount')
        );

    }// end of index

}//end of controller
