<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\StudentExamStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teacher\StudentExamAssessmentRequest;
use App\Http\Requests\Teacher\StudentExamDateTimeRequest;
use App\Http\Requests\Teacher\StudentExamRequest;
use App\Models\StudentExam;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StudentExamController extends Controller
{
    public function index()
    {
        return view('teacher.student_exams.index');

    }// end of index

    public function data()
    {
        $currentUserId = auth()->user()->id;
        $isExaminer = auth()->user()->is_examiner;
        
        $exams = StudentExam::query()
            ->with(['teacher', 'student', 'section', 'project'])
            ->where(function($query) use ($currentUserId, $isExaminer) {
                $query->where('teacher_id', $currentUserId);
                if ($isExaminer) {
                    $query->orWhere('examiner_id', $currentUserId);
                }
            })
            ->whenStudentId(request()->student_id)
            ->whenSectionId(request()->section_id)
            ->whenProjectId(request()->project_id)
            ->whenStatus(request()->status)
            ->whenAssessment(request()->assessment)
            ->whenAssignmentType(request()->assignment_type);

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
            ->addColumn('assignment_type', function (StudentExam $exam) {
                // Kiểm tra xem có phải bài kiểm tra theo lớp không
                $hasOtherExams = StudentExam::where('exam_id', $exam->exam_id)
                    ->where('section_id', $exam->section_id)
                    ->where('examiner_id', $exam->examiner_id)
                    ->where('id', '!=', $exam->id)
                    ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, created_at, ?)) <= 2', [$exam->created_at])
                    ->exists();
                
                if ($hasOtherExams) {
                    return '<span class="badge badge-primary">' . __('student_exams.assigned_by_class') . '</span>';
                } else {
                    return '<span class="badge badge-secondary">' . __('student_exams.assigned_individually') . '</span>';
                }
            })
            ->addColumn('status', function (StudentExam $exam) {
                return __('student_exams.' . $exam->status);
            })
            ->editColumn('created_at', function (StudentExam $exam) {
                return $exam->created_at->format('Y-m-d');
            })
            ->addColumn('actions', function (StudentExam $studentExam) {
                return view('teacher.student_exams.data_table.actions', compact('studentExam'));
            })
            ->rawColumns(['actions', 'assignment_type'])
            ->toJson();

    }// end of data

    public function create(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
        ]);

        $student = User::query()
            ->with(['studentProject.exams'])
            ->where('id', $request->student_id)
            ->first();

        $exams = $student->studentProject->exams;

        $examiners = User::query()
            ->whereRoleIs('examiner')
            ->get();

        return response()->json([
            'view' => view('teacher.student_exams._create', compact('exams', 'examiners', 'student'))->render(),
        ]);

    }// end of create

    public function store(StudentExamRequest $request)
    {
        $studentExam = StudentExam::create($request->validated());

        $studentExam->statuses()->create(['status' => StudentExamStatusEnum::ASSIGNED_TO_EXAMINER,]);

        return response()->json([
            'success_message' => __('site.added_successfully')
        ]);

    }// end of store

    public function show(StudentExam $studentExam)
    {
        return view('teacher.student_exams.show', compact('studentExam'));

    }// end of show

    public function editDateTime(StudentExam $studentExam)
    {
        $this->authorize('examiner_student_exam', $studentExam);

        return response()->json([
            'view' => view('teacher.student_exams._edit_date_time', compact('studentExam'))->render(),
        ]);

    }// end of editDateTime

    public function updateDateTime(StudentExamDateTimeRequest $request, StudentExam $studentExam)
    {
        $this->authorize('examiner_student_exam', $studentExam);

        $studentExam->update($request->validated());

        $studentExam->statuses()->create(['status' => StudentExamStatusEnum::DATE_TIME_SET]);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.student_exams.show', $studentExam->id),
        ]);

    }// end of updateDateTime

    public function editAssessment(StudentExam $studentExam)
    {
        $this->authorize('examiner_student_exam', $studentExam);

        return response()->json([
            'view' => view('teacher.student_exams._edit_assessment', compact('studentExam'))->render(),
        ]);

    }// end of editAssessment

    public function updateAssessment(StudentExamAssessmentRequest $request, StudentExam $studentExam)
    {
        $this->authorize('examiner_student_exam', $studentExam);

        $studentExam->update($request->validated());

        $studentExam->statuses()->create(['status' => StudentExamStatusEnum::ASSESSMENT_ADDED]);

        session()->flash('success', __('site.updated_successfully'));

        return response()->json([
            'redirect_to' => route('teacher.student_exams.show', $studentExam->id),
        ]);

    }// end of updateAssessment

    public function gradeExam(StudentExam $studentExam)
    {
        $this->authorize('examiner_student_exam', $studentExam);

        // Load exam với questions và answers của student
        $studentExam->load([
            'exam.questions', 
            'answers.question',
            'student'
        ]);

        return view('teacher.student_exams.grade', compact('studentExam'));

    }// end of gradeExam

    public function updateGrade(Request $request, StudentExam $studentExam)
    {
        $this->authorize('examiner_student_exam', $studentExam);

        $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'nullable|numeric|min:0',
            'comments' => 'array',
            'comments.*' => 'nullable|string|max:1000',
            'total_score' => 'nullable|numeric|min:0',
            'assessment' => 'nullable|string'
        ]);

        // Cập nhật điểm từng câu hỏi
        foreach ($request->scores as $answerId => $score) {
            if ($score !== null) {
                \App\Models\StudentExamAnswer::where('id', $answerId)
                    ->update([
                        'score' => $score,
                        'comment' => $request->comments[$answerId] ?? null
                    ]);
            }
        }

        // Tính lại tổng điểm và phần trăm
        $studentExam->load(['answers', 'exam.questions']);
        $totalScore = $studentExam->answers->whereNotNull('score')->sum('score');
        $maxScore = $studentExam->exam->questions->sum('points') ?? $studentExam->exam->questions->count();
        $percentage = $maxScore > 0 ? ($totalScore / $maxScore * 100) : 0;

        // Đánh giá tự động nếu chưa có
        $assessment = $request->assessment;
        $hasAnswers = $studentExam->answers->whereNotNull('answer_text')->count() > 0;
        if (!$assessment && $hasAnswers) {
            if ($percentage >= 90) $assessment = 'superiority';
            elseif ($percentage >= 80) $assessment = 'excellent';
            elseif ($percentage >= 70) $assessment = 'very_good';
            elseif ($percentage >= 60) $assessment = 'good';
            else $assessment = 'repeat';
        }

        // Cập nhật điểm tổng và đánh giá
        $updateData = [];
        if ($request->filled('total_score')) {
            $updateData['notes'] = 'Tổng điểm: ' . $request->total_score;
        }
        $updateData['assessment'] = $assessment;

        $studentExam->update($updateData);

        // Cập nhật trạng thái đã chấm điểm
        $studentExam->statuses()->create(['status' => StudentExamStatusEnum::ASSESSMENT_ADDED]);

        return redirect()->route('teacher.student_exams.show', $studentExam)
            ->with('success', 'Chấm điểm thành công!');

    }// end of updateGrade

    public function destroy(StudentExam $studentExam)
    {
        $this->authorize('teacher_student_exam', $studentExam);

        $studentExam->delete();

        return response()->json([
            'success_message' => __('site.deleted_successfully')
        ]);

    }// end of destroy

    /**
     * Show bulk set datetime form (for teachers with is_examiner)
     */
    public function showBulkSetDateTime()
    {
        // Check if teacher has is_examiner flag
        if (!auth()->user()->is_examiner) {
            return redirect()->route('teacher.student_exams.index')
                ->with('error', 'Bạn không có quyền truy cập chức năng này.');
        }

        // Get assignments grouped by exam and section for current teacher (as examiner)
        $assignmentGroups = StudentExam::query()
            ->with(['exam', 'section', 'project'])
            ->where('examiner_id', auth()->id())
            ->where('status', StudentExamStatusEnum::ASSIGNED_TO_EXAMINER)
            ->whereNull('date_time')
            ->get()
            ->groupBy(function($studentExam) {
                return $studentExam->exam_id . '_' . $studentExam->section_id;
            })
            ->map(function($group) {
                $first = $group->first();
                return [
                    'exam' => $first->exam,
                    'section' => $first->section,
                    'project' => $first->project,
                    'count' => $group->count(),
                    'exam_id' => $first->exam_id,
                    'section_id' => $first->section_id,
                    'students' => $group->pluck('student.name')->join(', ')
                ];
            });

        return view('teacher.student_exams.bulk_set_datetime', compact('assignmentGroups'));
    }

    /**
     * Bulk set datetime for students (for teachers with is_examiner)
     */
    public function bulkSetDateTime(Request $request)
    {
        // Check if teacher has is_examiner flag
        if (!auth()->user()->is_examiner) {
            return redirect()->route('teacher.student_exams.index')
                ->with('error', 'Bạn không có quyền truy cập chức năng này.');
        }

        $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'section_id' => 'required|exists:sections,id',
            'date_time' => 'required|date|after:now',
        ], [
            'date_time.required' => 'Vui lòng chọn thời gian kiểm tra.',
            'date_time.date' => 'Định dạng thời gian không hợp lệ.',
            'date_time.after' => 'Thời gian kiểm tra phải sau thời điểm hiện tại.',
        ]);

        try {
            DB::transaction(function() use ($request) {
                // Get all student exams for this exam and section
                $studentExams = StudentExam::query()
                    ->where('examiner_id', auth()->id())
                    ->where('exam_id', $request->exam_id)
                    ->where('section_id', $request->section_id)
                    ->where('status', StudentExamStatusEnum::ASSIGNED_TO_EXAMINER)
                    ->whereNull('date_time')
                    ->get();

                if ($studentExams->isEmpty()) {
                    throw new \Exception('Không tìm thấy bài kiểm tra nào để cập nhật.');
                }

                // Update all student exams
                foreach ($studentExams as $studentExam) {
                    $studentExam->update([
                        'date_time' => $request->date_time,
                        'status' => StudentExamStatusEnum::DATE_TIME_SET,
                    ]);

                    // Add status record
                    $studentExam->statuses()->create([
                        'status' => StudentExamStatusEnum::DATE_TIME_SET
                    ]);
                }
            });

            return redirect()->route('teacher.student_exams.index')
                ->with('success', 'Đã cập nhật thời gian kiểm tra cho tất cả sinh viên thành công.');

        } catch (\Exception $e) {
            Log::error('Teacher bulk set datetime error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật thời gian kiểm tra.')
                ->withInput();
        }
    }

}//end of controller
