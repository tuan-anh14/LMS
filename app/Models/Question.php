<?php

namespace App\Models;

use App\Enums\QuestionTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'content',
        'type', // 'text', 'multiple_choice', ...
        'options', // json cho trắc nghiệm
        'correct_answer',
        'points',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(StudentExamAnswer::class);
    }

    public function getTypeLabel()
    {
        return QuestionTypeEnum::getLabel($this->type);
    }

    public function isMultipleChoice()
    {
        return $this->type === QuestionTypeEnum::MULTIPLE_CHOICE;
    }

    public function isEssay()
    {
        return $this->type === QuestionTypeEnum::ESSAY;
    }
} 