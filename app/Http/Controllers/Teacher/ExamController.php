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
        // Lấy user hiện tại với type hint
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        // Lấy project IDs mà giảng viên đang dạy
        $teacherProjectIds = $user->getTeacherProjectIds();

        // Chỉ lấy các bài kiểm tra thuộc projects mà giảng viên đang dạy
        $exams = Exam::with('project')
            ->whereIn('project_id', $teacherProjectIds)
            ->get();
            
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
        // Lấy user hiện tại với type hint
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        // Lấy các sections mà giảng viên đang dạy trong center hiện tại
        $teacherSections = $user->teacherSections()
            ->wherePivot('center_id', session('selected_center')['id'])
            ->with('project')
            ->get();

        // Lấy các projects từ sections, loại bỏ duplicate
        $projects = $teacherSections
            ->pluck('project')
            ->unique('id')
            ->filter() // Loại bỏ null values
            ->values(); // Reset array keys

        return view('teacher.exams.create', compact('projects'));
    }

    public function store(Request $request)
    {
        // Lấy các project IDs mà giảng viên đang dạy
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $teacherProjectIds = $user->getTeacherProjectIds();

        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => [
                'required',
                'exists:projects,id',
                'in:' . implode(',', $teacherProjectIds)
            ],
        ], [
            'project_id.in' => 'Bạn chỉ có thể tạo bài kiểm tra cho môn học mà bạn đang dạy.'
        ]);

        Exam::create($request->only('name', 'project_id'));
        return redirect()->route('teacher.exams.index')->with('success', __('site.added_successfully'));
    }

    public function edit(Exam $exam)
    {
        // Kiểm tra authorization
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if (!$user->teachesProject($exam->project_id)) {
            abort(403, 'Bạn không có quyền chỉnh sửa bài kiểm tra này.');
        }

        // Lấy các sections mà giảng viên đang dạy trong center hiện tại
        $teacherSections = $user->teacherSections()
            ->wherePivot('center_id', session('selected_center')['id'])
            ->with('project')
            ->get();

        // Lấy các projects mà giảng viên đang dạy
        $projects = $teacherSections
            ->pluck('project')
            ->unique('id')
            ->filter()
            ->values();

        return view('teacher.exams.edit', compact('exam', 'projects'));
    }

    public function update(Request $request, Exam $exam)
    {
        // Kiểm tra authorization trước khi validate
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if (!$user->teachesProject($exam->project_id)) {
            abort(403, 'Bạn không có quyền chỉnh sửa bài kiểm tra này.');
        }

        $teacherProjectIds = $user->getTeacherProjectIds();

        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => [
                'required',
                'exists:projects,id',
                'in:' . implode(',', $teacherProjectIds)
            ],
        ], [
            'project_id.in' => 'Bạn chỉ có thể chỉnh sửa bài kiểm tra cho môn học mà bạn đang dạy.'
        ]);

        $exam->update($request->only('name', 'project_id'));
        return redirect()->route('teacher.exams.index')->with('success', __('site.updated_successfully'));
    }

    public function destroy(Exam $exam)
    {
        // Kiểm tra authorization
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if (!$user->teachesProject($exam->project_id)) {
            if (request()->ajax()) {
                return response()->json([
                    'error_message' => 'Bạn không có quyền xóa bài kiểm tra này.'
                ], 403);
            }
            abort(403, 'Bạn không có quyền xóa bài kiểm tra này.');
        }

        $exam->delete();
        if (request()->ajax()) {
            return response()->json([
                'success_message' => __('site.deleted_successfully')
            ]);
        }
        return redirect()->route('teacher.exams.index')->with('success', __('site.deleted_successfully'));
    }

}//end of controller
