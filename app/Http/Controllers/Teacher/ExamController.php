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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

    /**
     * Hiển thị form assign exam to class
     */
    public function showAssignForm(Exam $exam)
    {
        // Kiểm tra authorization - Teacher có dạy project của exam không
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if (!$user->teachesProject($exam->project_id)) {
            abort(403, 'Bạn không có quyền giao bài kiểm tra này.');
        }

        // Lấy các sections mà teacher đang dạy và thuộc cùng project với exam
        $sections = $user->teacherSections()
            ->wherePivot('center_id', session('selected_center')['id'])
            ->where('project_id', $exam->project_id)
            ->with(['students', 'project'])
            ->get();

        // Nếu không có sections nào, show error
        if ($sections->isEmpty()) {
            return redirect()->route('teacher.exams.index')
                ->with('error', 'Bạn không có lớp học nào thuộc môn học này để giao bài kiểm tra.');
        }

        // Lấy danh sách examiners (users có role examiner hoặc is_examiner = 1)
        $examiners = \App\Models\User::where(function($query) {
                $query->where('is_examiner', 1)
                      ->orWhereHas('roles', function($q) {
                          $q->where('name', 'examiner');
                      });
            })
            ->orderBy('first_name')
            ->get();

        return view('teacher.exams.assign', compact('exam', 'sections', 'examiners'));
    }

    /**
     * Xử lý assign exam to class
     */
    public function assignToClass(Request $request, Exam $exam)
    {
        try {
            // Kiểm tra authorization
            /** @var \App\Models\User $user */
            $user = auth()->user();
            
            if (!$user->teachesProject($exam->project_id)) {
                abort(403, 'Bạn không có quyền giao bài kiểm tra này.');
            }

        // Validate input
        $request->validate([
            'section_id' => [
                'required',
                'exists:sections,id',
                function ($attribute, $value, $fail) use ($user, $exam) {
                    // Check if teacher teaches this section
                    if (!$user->isTeacherForSectionIdInCenterId($value, session('selected_center')['id'])) {
                        $fail('Bạn không có quyền giao bài cho lớp học này.');
                    }
                    
                    // Check if section belongs to same project as exam
                    $section = \App\Models\Section::find($value);
                    if ($section && $section->project_id !== $exam->project_id) {
                        $fail('Lớp học này không thuộc môn học của bài kiểm tra.');
                    }
                },
            ],

            'notes' => 'nullable|string|max:500',
            'examiner_id' => [
                'required',
                'exists:users,id',
                function ($attribute, $value, $fail) {
                    $user = \App\Models\User::find($value);
                    if (!$user || (!$user->is_examiner && !$user->hasRole('examiner'))) {
                        $fail('Người dùng được chọn không phải là giám khảo.');
                    }
                },
            ],
        ], [
            'section_id.required' => 'Vui lòng chọn lớp học.',
            'section_id.exists' => 'Lớp học không tồn tại.',

            'notes.max' => 'Ghi chú không được vượt quá 500 ký tự.',
            'examiner_id.required' => 'Vui lòng chọn giám khảo.',
            'examiner_id.exists' => 'Giám khảo không tồn tại.',
        ]);

        // Lấy thông tin section
        $section = \App\Models\Section::findOrFail($request->section_id);
        
        // Lấy danh sách students trong section
        $students = $section->students()
            ->where('student_center_id', session('selected_center')['id'])
            ->get();

        if ($students->isEmpty()) {
            return redirect()->back()
                ->with('error', 'Lớp học này không có học sinh nào.')
                ->withInput();
        }

        // Kiểm tra duplicate assignment
        if (\App\Models\StudentExam::isExamAssignedToSection($exam->id, $section->id)) {
            return redirect()->back()
                ->with('error', 'Bài kiểm tra này đã được giao cho lớp học này rồi.')
                ->withInput();
        }

        // Tạo StudentExam records cho mỗi student với transaction
        DB::transaction(function () use ($students, $user, $request, $exam, $section) {
            foreach ($students as $student) {
                \App\Models\StudentExam::create([
                    'student_id' => $student->id,
                    'teacher_id' => $user->id,
                    'examiner_id' => $request->examiner_id,
                    'exam_id' => $exam->id,
                    'center_id' => session('selected_center')['id'],
                    'section_id' => $section->id,
                    'project_id' => $exam->project_id,
                    'status' => \App\Enums\StudentExamStatusEnum::ASSIGNED_TO_EXAMINER,
                    'notes' => $request->notes,
                ]);
            }
        });

        // Đếm số lượng học sinh được giao bài
        $assignedCount = $students->count();
        $examiner = \App\Models\User::find($request->examiner_id);

        return redirect()->route('teacher.exams.index')
            ->with('success', "Đã giao bài kiểm tra '{$exam->name}' cho {$assignedCount} học sinh trong lớp '{$section->name}' với giám khảo '{$examiner->full_name}'.");
        
        } catch (\Exception $e) {
            Log::error('Error in assignToClass: ' . $e->getMessage(), [
                'exam_id' => $exam->id,
                'user_id' => $user->id,
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi giao bài kiểm tra. Vui lòng thử lại.')
                ->withInput();
        }
    }

}//end of controller
