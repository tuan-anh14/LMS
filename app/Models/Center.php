<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //attr

    //scope

    //rel
    public function managers()
    {
        return $this->belongsToMany(User::class, 'center_manager', 'center_id', 'manager_id');

    }// end of managers

    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_center', 'center_id', 'teacher_id');

    }// end of teachers

    public function students()
    {
        return $this->hasMany(User::class, 'student_center_id');

    }// end of students

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_center');

    }// end of projects

    public function sections()
    {
        return $this->hasMany(Section::class);

    }// end of sections

    public function lectures()
    {
        return $this->hasMany(Lecture::class);

    }// end of lectures

    public function exams()
    {
        return $this->hasMany(StudentExam::class);

    }// end of exams

    //fun

}//end of model
