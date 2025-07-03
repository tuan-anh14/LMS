<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\UserTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StudentRequest;
use App\Models\Country;
use App\Models\StudentExam;
use App\Models\User;
use Yajra\DataTables\DataTables;

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
        $projects = session('selected_center')->projects;

        return view('teacher.exams.index', compact('projects'));

    }// end of index

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
        $this->authorize('center_manager', session('selected_center'));

        $countries = Country::query()
            ->get();

        $projects = session('selected_center')->projects;

        return view('teacher.exams.create', compact('countries', 'projects'));

    }// end of create

    public function store(StudentRequest $request)
    {
        $this->authorize('center_manager', session('selected_center'));

        $requestData = $request->validated();

        $requestData['password'] = bcrypt($request->password);

        $exam = User::create($requestData);

        $exam->attachRole(UserTypeEnum::STUDENT);

        session()->flash('success', __('site.added_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.exams.index'),
        ]);

    }// end of store

    public function edit(User $exam)
    {
        $exam->load(['governorate']);

        $countries = Country::query()
            ->get();

        $governorates = $exam->country->governorates;

        $projects = session('selected_center')->projects;

        $sections = $exam->examCenter->sections;

        return view('teacher.exams.edit', compact('countries', 'governorates', 'projects', 'sections', 'exam'));

    }// end of edit

    public function update(StudentRequest $request, User $exam)
    {
        $exam->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.exams.index'),
        ]);

    }// end of update

    public function destroy(User $exam)
    {
        $this->delete($exam);

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of destroy

    public function bulkDelete()
    {
        foreach (json_decode(request()->record_ids) as $recordId) {

            $exam = Teacher::FindOrFail($recordId);
            $this->delete($exam);

        }//end of for each

        return response()->json([
            'success_message' => __('site.deleted_successfully'),
        ]);

    }// end of bulkDelete

    private function delete(User $exam)
    {
        $exam->delete();

    }// end of delete

}//end of controller
