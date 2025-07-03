<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AttendanceStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\StudentLecture;
use Yajra\DataTables\DataTables;

class StudentLectureController extends Controller
{
    public function data()
    {
        $studentLectures = StudentLecture::query()
            ->with(['student', 'lecture', 'lecture.center', 'lecture.section'])
            ->withCount([
                'attendedStudents' => function ($query) {
                    $query->where('attendance_status', AttendanceStatusEnum::ATTENDED);
                },
                'absentStudents' => function ($query) {
                    $query->where('attendance_status', AttendanceStatusEnum::ABSENT);
                },
                'excuseStudents' => function ($query) {
                    $query->where('attendance_status', AttendanceStatusEnum::EXCUSE);
                },
            ])
            ->whenCenterId(request()->center_id)
            ->whenSectionId(request()->section_id)
            ->whenTeacherId(request()->teacher_id)
            ->whenStudentId(request()->student_id)
            ->whenAttendanceStatus(request()->attendance_status)
            ->whenDateRange(request()->date_range);

        return DataTables::of($studentLectures)
            // ->addColumn('record_select', 'admin.lectures.data_table.record_select')
            ->addColumn('name', function (StudentLecture $studentLecture) {
                return $studentLecture->lecture->name;
            })
            ->addColumn('type', function (StudentLecture $studentLecture) {
                return __('lectures.' . $studentLecture->lecture->type);
            })
            ->addColumn('attendance_status', function (StudentLecture $studentLecture) {
                return request()->student_id
                    ? __('lectures.' . $studentLecture->attendance_status)
                    : null;
            })
            ->addColumn('center', function (StudentLecture $studentLecture) {
                return $studentLecture->lecture->center->name;
            })
            ->addColumn('section', function (StudentLecture $studentLecture) {
                return $studentLecture->lecture->section->name;
            })
            ->editColumn('created_at', function (StudentLecture $studentLecture) {
                return $studentLecture->created_at->format('Y-m-d');
            })
            // ->addColumn('actions', function (StudentLecture $studentLecture) {
            //     return view('admin.student_lectures.data_table.actions', compact('studentLecture'));
            // })
            // ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

}//end of controller
