<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use Yajra\DataTables\DataTables;

class LectureController extends Controller
{
    public function data()
    {
        $lectures = Lecture::query()
            ->with(['teacher', 'section', 'center'])
            ->where('center_id', auth()->user()->student_center_id)
            ->where('section_id', auth()->user()->student_section_id)
            ->whenDate(request()->date)
            ->whenDateRange(request()->date_range)
            ->whenType(request()->type);

        return DataTables::of($lectures)
            ->addColumn('name', function (Lecture $lecture) {
                return $lecture->name;
            })
            ->addColumn('teacher', function (Lecture $lecture) {
                return $lecture->teacher->name;
            })
            ->addColumn('center', function (Lecture $lecture) {
                return $lecture->center->name;
            })
            ->addColumn('section', function (Lecture $lecture) {
                return $lecture->section->name;
            })
            ->addColumn('type', function (Lecture $lecture) {
                return __('lectures.' . $lecture->type);
            })
            ->addColumn('date', function (Lecture $lecture) {
                return $lecture->date->format('Y-m-d');
            })
            ->editColumn('created_at', function (Lecture $lecture) {
                return $lecture->created_at->format('Y-m-d H:i');
            })
            ->rawColumns([])
            ->toJson();

    }// end of data

}//end of controller 