<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentExam;
use Yajra\DataTables\DataTables;
use App\Enums\StudentExamStatusEnum;

class StudentExamController extends Controller
{
    public function index()
    {
        return view('student.student_exams.index');

    }// end of index

    public function data()
    {
        $exams = StudentExam::query()
            ->with(['teacher', 'examiner', 'student', 'section', 'project', 'exam'])
            ->where('student_id', auth()->id())
            ->whenTeacherId(request()->teacher_id)
            ->whenExaminerId(request()->examiner_id)
            ->whenSectionId(request()->section_id)
            ->whenProjectId(request()->project_id)
            ->whenDateRange(request()->date_range)
            ->whenStatus(request()->status)
            ->whenAssessment(request()->assessment);

        return DataTables::of($exams)
            ->addColumn('teacher', function (StudentExam $exam) {
                return $exam->teacher?->name;
            })
            ->addColumn('examiner', function (StudentExam $exam) {
                return $exam->examiner?->name;
            })
            ->addColumn('project', function (StudentExam $exam) {
                return $exam->project->name;
            })
            ->addColumn('section', function (StudentExam $exam) {
                return $exam->section->name;
            })
            ->addColumn('exam', function (StudentExam $exam) {
                return $exam->exam?->name;
            })
            ->addColumn('status', function (StudentExam $exam) {
                return __('student_exams.' . $exam->status);
            })
            ->addColumn('assessment', function (StudentExam $exam) {
                return $exam->assessment ? __('student_exams.' . $exam->assessment) : '';
            })
            ->editColumn('created_at', function (StudentExam $exam) {
                return $exam->created_at->format('Y-m-d');
            })
            ->editColumn('date_time', function (StudentExam $exam) {
                return $exam->date_time ? $exam->date_time->format('Y-m-d H:i') : '';
            })
            ->addColumn('actions', function (StudentExam $studentExam) {
                return view('student.student_exams.data_table.actions', compact('studentExam'));
            })
            ->rawColumns(['actions'])
            ->toJson();

    }// end of data

    public function show(StudentExam $studentExam)
    {
        // Ensure student can only view their own exams
        if ($studentExam->student_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $studentExam->load(['teacher', 'examiner', 'student', 'section', 'project', 'exam', 'statuses']);

        return view('student.student_exams.show', compact('studentExam'));

    }// end of show

    public function take(StudentExam $studentExam)
    {
        if ($studentExam->student_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        // Giả định exam có quan hệ questions
        $exam = $studentExam->exam()->with('questions')->first();
        return view('student.student_exams.take', compact('studentExam', 'exam'));
    }

    public function submit(StudentExam $studentExam)
    {
        if ($studentExam->student_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        $answers = request('answers', []);
        foreach ($answers as $question_id => $answer_text) {
            \App\Models\StudentExamAnswer::updateOrCreate([
                'student_exam_id' => $studentExam->id,
                'question_id' => $question_id,
            ], [
                'answer_text' => $answer_text,
                'submitted_at' => now(),
            ]);
        }
        // Có thể cập nhật trạng thái đã nộp bài
        $studentExam->update(['status' => StudentExamStatusEnum::SUBMITTED]);
        return redirect()->route('student.student_exams.show', $studentExam)->with('success', 'Nộp bài thành công!');
    }

    public function results(StudentExam $studentExam)
    {
        if ($studentExam->student_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Load tất cả dữ liệu cần thiết
        $studentExam->load([
            'exam.questions', 
            'answers.question',
            'teacher',
            'examiner'
        ]);

        return view('student.student_exams.results', compact('studentExam'));
    }

}//end of controller 