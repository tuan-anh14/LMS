<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\StudentExamStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\StudentExam;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $center = Center::query()
            ->withCount([
                'managers', 'teachers', 'students', 'projects', 'exams', 'sections', 'lectures'
            ])
            ->where('id', session('selected_center')['id'])
            ->first();

        // Thống kê cho teacher
        $currentUserId = auth()->user()->id;
        $isExaminer = auth()->user()->is_examiner;
        
        // Tổng số bài kiểm tra (bài mà teacher giao + bài mà teacher làm examiner nếu có)
        $assignedStudentExamsCount = StudentExam::query()
            ->where(function($query) use ($currentUserId, $isExaminer) {
                $query->where('teacher_id', $currentUserId);
                if ($isExaminer) {
                    $query->orWhere('examiner_id', $currentUserId);
                }
            })
            ->count();

        // Số bài kiểm tra được giao theo lớp
        // Logic: Những bài được tạo cùng lúc (trong 2 phút) và cùng exam_id, section_id, examiner_id
        $assignedByClassCount = StudentExam::query()
            ->where(function($query) use ($currentUserId, $isExaminer) {
                $query->where('teacher_id', $currentUserId);
                if ($isExaminer) {
                    $query->orWhere('examiner_id', $currentUserId);
                }
            })
            ->whereIn('id', function($query) use ($currentUserId, $isExaminer) {
                $query->select('se1.id')
                    ->from('student_exams as se1')
                    ->where(function($subQuery) use ($currentUserId, $isExaminer) {
                        $subQuery->where('se1.teacher_id', $currentUserId);
                        if ($isExaminer) {
                            $subQuery->orWhere('se1.examiner_id', $currentUserId);
                        }
                    })
                    ->whereExists(function($existsQuery) {
                        $existsQuery->select(DB::raw(1))
                            ->from('student_exams as se2')
                            ->whereRaw('se2.exam_id = se1.exam_id')
                            ->whereRaw('se2.section_id = se1.section_id')
                            ->whereRaw('se2.examiner_id = se1.examiner_id')
                            ->whereRaw('se2.id != se1.id')
                            ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, se1.created_at, se2.created_at)) <= 2');
                    });
            })
            ->count();

        // Số bài kiểm tra được giao riêng lẻ
        $assignedIndividualCount = $assignedStudentExamsCount - $assignedByClassCount;

        return view('teacher.home',
            compact('center', 'assignedStudentExamsCount', 'assignedByClassCount', 'assignedIndividualCount')
        );

    }// end of index

}//end of controller
