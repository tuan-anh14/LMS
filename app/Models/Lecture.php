<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'center_id', 'section_id', 'date', 'type'];

    protected $casts = [
        'date' => 'date',
    ];

    //attr
    public function getNameAttribute()
    {
        return __('lectures.lecture') . ' ' . $this->date->translatedFormat('l Y-m-d');

    }// end of getNameAttribute

    //scope
    public function scopeWhenTeacherId($query, $teacherId)
    {
        return $query->when($teacherId, function ($q) use ($teacherId) {

            return $q->where('teacher_id', $teacherId);

        });

    }// end of scopeWhenTeacherId

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

    public function scopeWhenDate($query, $date)
    {
        return $query->when($date, function ($q) use ($date) {

            return $q->whereDate('date', $date);

        });

    }// end of scopeWhenDate

    public function scopeWhenDateRange($query, $dateRange)
    {
        return $query->when((
            isset($dateRange['from']) &&
            isset($dateRange['to']
            )
        ), function ($q) use ($dateRange) {

            return $q->whereDate('date', '>=', $dateRange['from'])
                ->whereDate('date', '<=', $dateRange['to']);

        });

    }// end of scopeWhenDateRange

    public function scopeWhenStudentId($query, $studentId)
    {
        return $query->when($studentId, function ($q) use ($studentId) {

            return $q->whereHas('students', function ($qu) use ($studentId) {
                return $qu->where('id', $studentId);
            });

        });

    }// end of scopeWhenStudentId

    public function scopeWhenAttendanceStatus($query, $attendanceStatus)
    {
        return $query->when($attendanceStatus, function ($q) use ($attendanceStatus) {

            return $q->whereHas('students', function ($qu) use ($attendanceStatus) {

                return $qu->where('attendance_status', $attendanceStatus);

            });

        });

    }// end of scopeWhenAttendanceStatus

    public function scopeWhenType($query, $type)
    {
        return $query->when($type, function ($q) use ($type) {

            return $q->where('type', $type);

        });

    }// end of scopeWhenType


    //rel
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');

    }//end of teacher

    public function center()
    {
        return $this->belongsTo(Center::class);

    }// end of center

    public function section()
    {
        return $this->belongsTo(Section::class);

    }// end of section

    public function students()
    {
        return $this->hasMany(StudentLecture::class);

    }// end of students

    public function pages()
    {
        return $this->hasMany(Page::class);

    }// end of pages

    //fun
    public function canBeDeleted()
    {
        return $this->teacher_id == auth()->user()->id && $this->students->count() == 0;

    }// end of canBeDeleted

}//end of model
