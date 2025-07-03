<?php

namespace App\Models;

use App\Enums\AttendanceStatusEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class StudentLecture extends Model
{
    protected $fillable = [
        'center_id', 'section_id', 'teacher_id', 'student_id', 'lecture_id', 'project_id', 'book_id', 'attendance_status', 'notes'
    ];

    //attr

    //scope
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

    public function scopeWhenBookId($query, $bookId)
    {
        return $query->when($bookId, function ($q) use ($bookId) {

            return $q->where('book_id', $bookId);

        });

    }// end of scopeWhenBookId

    public function scopeWhenStudentId($query, $studentId)
    {
        return $query->when($studentId, function ($q) use ($studentId) {

            return $q->where('student_id', $studentId);

        });

    }// end of scopeWhenStudentId

    public function scopeWhenTeacherId($query, $teacherId)
    {
        return $query->when($teacherId, function ($q) use ($teacherId) {

            return $q->where('teacher_id', $teacherId);

        });

    }// end of scopeWhenTeacherId

    public function scopeWhenAttendanceStatus($query, $attendanceStatus)
    {
        return $query->when($attendanceStatus, function ($q) use ($attendanceStatus) {

            return $q->where('attendance_status', $attendanceStatus);

        });

    }// end of scopeWhenAttendanceStatus

    public function scopeWhenDateRange($query, $dateRange)
    {
        return $query->when((
            isset($dateRange['from']) &&
            isset($dateRange['to']
            )
        ), function ($q) use ($dateRange) {

            return $q->whereDate('created_at', '>=', $dateRange['from'])
                ->whereDate('created_at', '<=', $dateRange['to']);

        });

    }// end of scopeWhenDateRange

    public function scopeWhenLectureDateRange($query, $lectureDateRange)
    {
        return $query->when(
            (
                isset($lectureDateRange['from']) &&
                isset($lectureDateRange['to'])
            ),
            function ($q) use ($lectureDateRange) {

                return $q->whereHas('lecture', function ($qu) use ($lectureDateRange) {
                    $qu->whereDate('date', '>=', Carbon::parse($lectureDateRange['from'])->format('Y-m-d'))
                        ->whereDate('date', '<=', Carbon::parse($lectureDateRange['to'])->format('Y-m-d'));
                });

            });

    }// end of scopeWhenLectureDateRange

    //rel
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

    public function book()
    {
        return $this->belongsTo(Book::class);

    }// end of book

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);

    }// end of lecture

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');

    }// end of teacher

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');

    }// end of student

    public function pages()
    {
        return $this->hasMany(Page::class);

    }// end of pages

    public function attendedStudents()
    {
        return $this->hasMany(StudentLecture::class, 'student_id', 'student_id')
            ->where('attendance_status', AttendanceStatusEnum::ATTENDED);
    }

    public function absentStudents()
    {
        return $this->hasMany(StudentLecture::class, 'student_id', 'student_id')
            ->where('attendance_status', AttendanceStatusEnum::ABSENT);
    }

    public function excuseStudents()
    {
        return $this->hasMany(StudentLecture::class, 'student_id', 'student_id')
            ->where('attendance_status', AttendanceStatusEnum::EXCUSE);
    }
    //fun

}//end of model
