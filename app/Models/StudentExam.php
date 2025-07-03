<?php

namespace App\Models;

use App\Enums\StudentExamStatusEnum;
use Illuminate\Database\Eloquent\Model;

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

    //fun
    public function canBeDeletedByTeacher()
    {
        return $this->status == StudentExamStatusEnum::ASSIGNED_TO_EXAMINER &&
            $this->teacher_id == auth()->id();

    }// end of canBeDeleted

}//end of model
