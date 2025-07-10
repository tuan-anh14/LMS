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

class StudentExamController extends Controller
{
    public function index()
    {
        return view('teacher.student_exams.index');

    }// end of index

    public function data()
    {
        $exams = StudentExam::query()
            ->with(['teacher', 'student', 'section', 'project'])
            //->whenTeacherId(request()->teacher_id)
            ->whenExaminerId(request()->examiner_id)
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
                return __('student_exams.' . $exam->status);
            })
            ->editColumn('created_at', function (StudentExam $exam) {
                return $exam->created_at->format('Y-m-d');
            })
            ->addColumn('actions', function (StudentExam $studentExam) {
                return view('teacher.student_exams.data_table.actions', compact('studentExam'));
            })
            ->rawColumns(['actions'])
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

}//end of controller
