<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Exam $exam)
    {
        $questions = $exam->questions;
        return view('teacher.questions.index', compact('exam', 'questions'));
    }

    public function create(Exam $exam)
    {
        return view('teacher.questions.create', compact('exam'));
    }

    public function store(Request $request, Exam $exam)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        $exam->questions()->create([
            'content' => $request->content,
        ]);
        return redirect()->route('teacher.exams.questions.index', $exam->id)->with('success', __('site.added_successfully'));
    }

    public function edit(Exam $exam, Question $question)
    {
        return view('teacher.questions.edit', compact('exam', 'question'));
    }

    public function update(Request $request, Exam $exam, Question $question)
    {
        $request->validate([
            'content' => 'required|string',
        ]);
        $question->update([
            'content' => $request->content,
        ]);
        return redirect()->route('teacher.exams.questions.index', $exam->id)->with('success', __('site.updated_successfully'));
    }

    public function destroy(Exam $exam, Question $question)
    {
        $question->delete();
        return redirect()->route('teacher.exams.questions.index', $exam->id)->with('success', __('site.deleted_successfully'));
    }
} 