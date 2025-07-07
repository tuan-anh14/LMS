<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExamAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_exam_id',
        'question_id',
        'answer_text',
        'file_path',
        'submitted_at',
        'score',
        'comment'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'score' => 'float'
    ];

    public function studentExam()
    {
        return $this->belongsTo(StudentExam::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
} 