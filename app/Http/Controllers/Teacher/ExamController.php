<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StudentRequest;
use App\Models\Country;
use App\Models\StudentExam;
use App\Models\User;
use Yajra\DataTables\DataTables;
use App\Models\Exam;
use App\Models\Project;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_exams')->only(['index']);
        $this->middleware('permission:create_exams')->only(['create', 'store']);
        $this->middleware('permission:update_exams')->only(['edit', 'update']);
        $this->middleware('permission:delete_exams')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index()
    {
        $exams = Exam::with('project')->whereIn('project_id', session('selected_center')->projects->pluck('id'))->get();
        return view('teacher.exams.index', compact('exams'));
    }

    public function data(User $teacher)
    {
        $exams = StudentExam::query()
            ->with(['teacher', 'student', 'section', 'project'])
            ->whenTeacherId(request()->teacher_id)
            ->whenExaminerId($teacher->id)
            ->whenStudentId(request()->student_id)
            ->whenSectionId(request()->section_id)
            ->whenProjectId(request()->project_id)
            ->whenStatus(request()->status)
            ->whenAssessment(request()->assessment);

        return DataTables::of($exams)
            ->addColumn('teacher', function (StudentExam $exam) {
                return $exam->teacher?->name;
            })
            ->addColumn('examiner', function (StudentExam $exam) {
                return $exam->examiner?->name;
            })
            ->addColumn('student', function (StudentExam $exam) {
                return $exam->student->name;
            })
            ->addColumn('project', function (StudentExam $exam) {
                return $exam->project->name;
            })
            ->addColumn('section', function (StudentExam $exam) {
                return $exam->section->name;
            })
            ->addColumn('status', function (StudentExam $exam) {
                return __('exams.' . $exam->status);
            })
            ->editColumn('created_at', function (StudentExam $exam) {
                return $exam->created_at->format('Y-m-d');
            })
            ->addColumn('actions', function (StudentExam $studentExam) use ($teacher) {
                return view('teacher.students.exams.data_table.actions', compact('studentExam', 'student'));
            })
            ->rawColumns(['actions'])
            ->toJson();


    }// end of data

    public function create()
    {
        $projects = session('selected_center')->projects;
        return view('teacher.exams.create', compact('projects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);
        Exam::create($request->only('name', 'project_id'));
        return redirect()->route('teacher.exams.index')->with('success', __('site.added_successfully'));
    }

    public function edit(Exam $exam)
    {
        $projects = session('selected_center')->projects;
        return view('teacher.exams.edit', compact('exam', 'projects'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);
        $exam->update($request->only('name', 'project_id'));
        return redirect()->route('teacher.exams.index')->with('success', __('site.updated_successfully'));
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return redirect()->route('teacher.exams.index')->with('success', __('site.deleted_successfully'));
    }

}//end of controller
