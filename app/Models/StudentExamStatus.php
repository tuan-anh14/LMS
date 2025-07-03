<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExamStatus extends Model
{
    use HasFactory;

    protected $fillable = ['student_exam_id', 'status'];

    //attr

    //scope

    //rel
    public function studentExam()
    {
        return $this->belongsTo(StudentExam::class);

    }// end of studentExam

    //fun

}//end of model
