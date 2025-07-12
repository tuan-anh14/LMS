<?php

namespace App\Models;

use App\Enums\StudentExamStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StudentExam extends Model
{
    protected $fillable = [
        'student_id', 'teacher_id', 'examiner_id', 'exam_id', 'center_id', 'section_id', 'project_id',
        'status', 'assessment', 'notes', 'time', 'date', 'date_time',
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'date' => 'date',
    ];

    //attr

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->second_name . ' (' . $this->nickname . ')';

    }// end of getNameFullAttribute

    //scope
    public function scopeWhenStudentId($query, $studentId)
    {
        return $query->when($studentId, function ($q) use ($studentId) {

            return $q->where('student_id', $studentId);

        });

    }// end of scopeWhenStudentId

    public function scopeWhenTeacherId($query, $teacher)
    {
        return $query->when($teacher, function ($q) use ($teacher) {

            return $q->where('teacher_id', $teacher);

        });

    }// end of scopeWhenTeacherId

    public function scopeWhenExaminerId($query, $examinerId)
    {
        return $query->when($examinerId, function ($q) use ($examinerId) {

            return $q->where('examiner_id', $examinerId);

        });

    }// end of scopeWhenExaminerId

    public function scopeWhenCenterId($query, $centerId)
    {
        return $query->when($centerId, function ($q) use ($centerId) {

            return $q->where('center_id', $centerId);

        });

    }// end of scopeWhenCenterId

    public function scopeWhenSectionId($query, $sectionId)
    {
        return $query->when($sectionId, function ($q) use ($sectionId) {

            return $q->where('section_id', $sectionId);

        });

    }// end of scopeWhenSectionId

    public function scopeWhenProjectId($query, $projectId)
    {
        return $query->when($projectId, function ($q) use ($projectId) {

            return $q->where('project_id', $projectId);

        });

    }// end of scopeWhenProjectId

    public function scopeWhenAssessment($query, $assessment)
    {
        return $query->when($assessment, function ($q) use ($assessment) {

            return $q->where('assessment', $assessment);

        });

    }// end of scopeWhenAssessment

    public function scopeWhenStatus($query, $status)
    {
        return $query->when($status, function ($q) use ($status) {

            return $q->where('status', $status);

        });

    }// end of scopeWhenStatus

    public function scopeWhenDateRange($query, $dateRange)
    {
        return $query->when((
            isset($dateRange['from']) &&
            isset($dateRange['to']
            )
        ), function ($q) use ($dateRange) {

            return $q->whereDate('date_time', '>=', $dateRange['from'])
                ->whereDate('date_time', '<=', $dateRange['to']);

        });

    }// end of scopeWhenDateRange

    public function scopeWhenAssignmentType($query, $assignmentType)
    {
        return $query->when($assignmentType, function ($q) use ($assignmentType) {
            if ($assignmentType === 'class') {
                // Bài kiểm tra theo lớp: những bài được tạo hàng loạt
                // Logic: có ít nhất 2 bài cùng exam_id, section_id và được tạo gần nhau (trong 2 phút)
                return $q->whereIn('id', function($subQuery) {
                    $subQuery->select('se1.id')
                        ->from('student_exams as se1')
                        ->whereExists(function($existsQuery) {
                            $existsQuery->select(DB::raw(1))
                                ->from('student_exams as se2')
                                ->whereRaw('se2.exam_id = se1.exam_id')
                                ->whereRaw('se2.section_id = se1.section_id')
                                ->whereRaw('se2.examiner_id = se1.examiner_id')
                                ->whereRaw('se2.id != se1.id')
                                ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, se1.created_at, se2.created_at)) <= 2');
                        });
                });
            } elseif ($assignmentType === 'individual') {
                // Bài kiểm tra cá nhân: những bài không có bài nào khác cùng exam_id, section_id được tạo gần nhau
                return $q->whereNotIn('id', function($subQuery) {
                    $subQuery->select('se1.id')
                        ->from('student_exams as se1')
                        ->whereExists(function($existsQuery) {
                            $existsQuery->select(DB::raw(1))
                                ->from('student_exams as se2')
                                ->whereRaw('se2.exam_id = se1.exam_id')
                                ->whereRaw('se2.section_id = se1.section_id')
                                ->whereRaw('se2.examiner_id = se1.examiner_id')
                                ->whereRaw('se2.id != se1.id')
                                ->whereRaw('ABS(TIMESTAMPDIFF(MINUTE, se1.created_at, se2.created_at)) <= 2');
                        });
                });
            }
        });
    }// end of scopeWhenAssignmentType

    //rel
    public function exam()
    {
        return $this->belongsTo(Exam::class);

    }// end of exam

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');

    }// end of student

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');

    }// end of teacher

    public function examiner()
    {
        return $this->belongsTo(User::class, 'examiner_id');

    }// end of examiner

    public function center()
    {
        return $this->belongsTo(Center::class);

    }// end of center

    public function section()
    {
        return $this->belongsTo(Section::class);

    }// end of section

    public function project()
    {
        return $this->belongsTo(Project::class);

    }// end of project

    public function statuses()
    {
        return $this->hasMany(StudentExamStatus::class);

    }// end of statuses

    public function answers()
    {
        return $this->hasMany(StudentExamAnswer::class);

    }// end of answers

    //fun
    public function canBeDeletedByTeacher()
    {
        return $this->status == StudentExamStatusEnum::ASSIGNED_TO_EXAMINER &&
            $this->teacher_id == auth()->id();

    }// end of canBeDeleted

    /**
     * Check if exam is already assigned to students in section
     */
    public static function isExamAssignedToSection($examId, $sectionId)
    {
        return self::where('exam_id', $examId)
            ->where('section_id', $sectionId)
            ->exists();
    }

    /**
     * Get assigned students count for exam in section
     */
    public static function getAssignedStudentsCount($examId, $sectionId)
    {
        return self::where('exam_id', $examId)
            ->where('section_id', $sectionId)
            ->count();
    }

    /**
     * Get the timestamp when exam was assigned to examiner
     */
    public function getAssignedAtAttribute()
    {
        $status = $this->statuses()->where('status', StudentExamStatusEnum::ASSIGNED_TO_EXAMINER)->first();
        return $status ? $status->created_at : $this->created_at;
    }

    /**
     * Get the timestamp when datetime was set
     */
    public function getDateTimeSetAtAttribute()
    {
        $status = $this->statuses()->where('status', StudentExamStatusEnum::DATE_TIME_SET)->first();
        return $status ? $status->created_at : null;
    }

    /**
     * Get the timestamp when assessment was added
     */
    public function getAssessmentAddedAtAttribute()
    {
        $status = $this->statuses()->where('status', StudentExamStatusEnum::ASSESSMENT_ADDED)->first();
        return $status ? $status->created_at : null;
    }

    /**
     * Get the timestamp when exam was submitted
     */
    public function getSubmittedAtAttribute()
    {
        $status = $this->statuses()->where('status', StudentExamStatusEnum::SUBMITTED)->first();
        return $status ? $status->created_at : null;
    }

    /**
     * Get formatted timeline of all statuses
     */
    public function getTimelineAttribute()
    {
        $timeline = [];
        
        $timeline[] = [
            'status' => 'created',
            'timestamp' => $this->created_at,
            'label' => __('student_exams.created'),
        ];

        foreach ($this->statuses as $status) {
            $timeline[] = [
                'status' => $status->status,
                'timestamp' => $status->created_at,
                'label' => __('student_exams.' . $status->status),
            ];
        }

        return collect($timeline)->sortBy('timestamp');
    }

}//end of model
