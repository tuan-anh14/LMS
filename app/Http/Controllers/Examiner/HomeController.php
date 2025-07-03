<?php

namespace App\Http\Controllers\Examiner;

use App\Enums\StudentExamStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\StudentExam;

class HomeController extends Controller
{
    public function index()
    {
        $assignedStudentExamsCount = StudentExam::query()
            ->with(['teacher', 'student', 'section', 'project'])
            ->whenExaminerId(auth()->user()->id)
            ->whenStatus(StudentExamStatusEnum::ASSIGNED_TO_EXAMINER)->count();

        return view('examiner.home',
            compact('assignedStudentExamsCount')
        );

    }// end of index

}//end of controller
