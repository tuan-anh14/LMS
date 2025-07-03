<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'center_id', 'section_id', 'book_id', 'teacher_id', 'student_id', 'student_lecture_id', 'assessment',
        'from', 'to',
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

    public function scopeWhenTeacherId($query, $teacherId)
    {
        return $query->when($teacherId, function ($q) use ($teacherId) {

            return $q->where('teacher_id', $teacherId);

        });

    }// end of scopeWhenTeacherId

    public function scopeWhenStudentId($query, $studentId)
    {
        return $query->when($studentId, function ($q) use ($studentId) {

            return $q->where('student_id', $studentId);

        });

    }// end of scopeWhenStudentId

    public function scopeWhenBookId($query, $bookId)
    {
        return $query->when($bookId, function ($q) use ($bookId) {

            return $q->where('book_id', $bookId);

        });

    }// end of scopeWhenBookId

    public function scopeWhenAssessment($query, $assessment)
    {
        return $query->when($assessment, function ($q) use ($assessment) {

            return $q->where('assessment', $assessment);

        });

    }// end of scopeWhenAssessment

    public function scopeWhenLectureId($query, $lectureId)
    {
        return $query->when($lectureId, function ($q) use ($lectureId) {

            return $q->where('lecture_id', $lectureId);

        });

    }// end of scopeWhenLectureId


    //rel
    public function center()
    {
        return $this->belongsTo(Center::class);

    }// end of center

    public function section()
    {
        return $this->belongsTo(Section::class);

    }// end of section

    public function book()
    {
        return $this->belongsTo(Book::class);

    }// end of book

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');

    }// end of teacher

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');

    }// end of student

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);

    }// end of lecture

    public function studentLecture()
    {
        return $this->belongsTo(StudentLecture::class);

    }// end of studentLecture

    //fun

}//end of model
