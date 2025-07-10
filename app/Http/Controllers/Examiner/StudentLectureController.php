<?php

namespace App\Http\Controllers\Examiner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StudentLectureRequest;
use App\Models\StudentLecture;
use App\Models\User;
use App\Services\LectureService;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StudentLectureController extends Controller
{
    public function data()
    {
        $studentLectures = StudentLecture::query()
            ->with(['student', 'lecture', 'lecture.center', 'lecture.section'])
            ->whenCenterId(session('selected_center')['id'])
            ->whenSectionId(request()->section_id)
            ->whenTeacherId(auth()->user()->hasRole('center_manager') ? request()->teacher_id : auth()->user()->id)
            ->whenStudentId(request()->student_id)
            ->whenAttendanceStatus(request()->attendance_status);

        return DataTables::of($studentLectures)
            ->addColumn('record_select', 'teacher.lectures.data_table.record_select')
            ->addColumn('name', function (StudentLecture $studentLecture) {
                return $studentLecture->lecture->name;
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
            ->addColumn('actions', function (StudentLecture $studentLecture) {
                return view('teacher.student_lectures.data_table.actions', compact('studentLecture'));
            })
            ->rawColumns(['record_select', 'actions'])
            ->toJson();

    }// end of data

    public function create(Request $request)
    {
        $requestData = $request->validate([
            'student_id' => 'required|integer|exists:users,id',
        ]);

        $student = User::query()
            ->where('id', $request->student_id)
            ->firstOrFail();

        $lectures = auth()->user()->teacherLectures()
            ->whereDoesntHave('students', function ($q) use ($student) {
                $q->where('student_id', $student->id);
            })
            ->get();

        return response()->json([
            'view' => view('teacher.student_lectures._create', compact('lectures', 'student'))->render(),
        ]);

    }// end of create

    public function store(StudentLectureRequest $request, LectureService $lectureService)
    {
        $lectureService->storeStudentLecture($request);

        return response()->json([
            'success_message' => __('site.added_successfully'),
        ]);

    }// end of store

    public function edit(StudentLecture $studentLecture)
    {
        $studentLecture->load(['center', 'section', 'project', 'lecture', 'teacher', 'student'])
            ->loadCount(['pages']);

        return response()->json([
            'view' => view('teacher.student_lectures._edit', compact('studentLecture'))->render(),
        ]);

    }// end of edit

    public function update(StudentLectureRequest $request, LectureService $lectureService, StudentLecture $studentLecture)
    {
        $lectureService->updateStudentLecture($request, $studentLecture);

        return response()->json([
            'success_message' => __('site.added_successfully'),
        ]);

    }// end of update

}//end of controller
