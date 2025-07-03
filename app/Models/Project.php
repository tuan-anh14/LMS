<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'name', 'has_tajweed_lectures', 'has_upbringing_lectures'];

    //attr

    //scope
    public function scopeWhenCenterId($query, $centerId)
    {
        return $query->when($centerId, function ($q) use ($centerId) {

            return $q->whereHas('centers', function ($qu) use ($centerId) {
                $qu->where('id', $centerId);
            });

        });

    }// end of scopeWhenCenterId

    public function scopeWhenBookId($query, $bookId)
    {
        return $query->when($bookId, function ($q) use ($bookId) {

            return $q->where('book_id', $bookId);

        });

    }// end of scopeWhenBookId

    //rel
    public function centers()
    {
        return $this->belongsToMany(Center::class, 'project_center');

    }// end of center

    public function sections()
    {
        return $this->hasMany(Section::class);

    }// end of sessions

    public function book()
    {
        return $this->belongsTo(Book::class);

    }// end of book

    public function students()
    {
        return $this->hasMany(User::class, 'student_project_id');

    }// end of students

    public function exams()
    {
        return $this->hasMany(Exam::class);

    }// end of exams

    //fun
    public function hasTajweedLectures()
    {
        return $this->has_tajweed_lectures;

    }// end of hasTajweedLectures

    public function hasUpbringingLectures()
    {
        return $this->has_upbringing_lectures;

    }// end of hasUpbringingLectures

    public function isInCenterId($centerId)
    {
        return $this->centers->contains($centerId);

    }// end of isInCenterId

    public function canBeDeleted()
    {
        return $this->sections->count() == 0 && $this->students->count() == 0;

    }// end of canBeDeleted

}//end of project
