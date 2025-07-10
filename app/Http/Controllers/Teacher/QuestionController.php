<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\QuestionTypeEnum;
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
        $questionTypes = QuestionTypeEnum::getLabels();
        return view('teacher.questions.create', compact('exam', 'questionTypes'));
    }

    public function store(Request $request, Exam $exam)
    {
        // Dynamic validation rules based on question type
        $rules = [
            'content' => 'required|string',
            'type' => 'required|in:' . implode(',', QuestionTypeEnum::getConstants()),
            'points' => 'required|numeric|min:0.1',
            'options.*' => 'nullable|string',
        ];

        // Add conditional validation for correct_answer
        if ($request->type === QuestionTypeEnum::MULTIPLE_CHOICE) {
            $rules['correct_answer'] = 'required|string';
            $rules['options'] = 'required|array|min:2';
            $rules['options.*'] = 'required|string';
        } else {
            $rules['correct_answer'] = 'nullable|string';
        }

        $request->validate($rules);

        $questionData = [
            'content' => $request->content,
            'type' => $request->type,
            'points' => $request->points,
            'correct_answer' => $request->correct_answer,
        ];

        // Handle options for multiple choice questions
        if ($request->type === QuestionTypeEnum::MULTIPLE_CHOICE) {
            $options = array_filter($request->input('options', []));
            $questionData['options'] = $options;

            // Ensure correct_answer is one of the options (for multiple choice)
            if (!in_array($request->correct_answer, $options)) {
                return back()->withErrors(['correct_answer' => 'Đáp án đúng phải là một trong các tùy chọn được cung cấp.'])->withInput();
            }
        } else {
            $questionData['options'] = null;
        }

        $exam->questions()->create($questionData);

        return redirect()->route('teacher.exams.questions.index', $exam->id)->with('success', __('site.added_successfully'));
    }

    public function edit(Exam $exam, Question $question)
    {
        $questionTypes = QuestionTypeEnum::getLabels();
        return view('teacher.questions.edit', compact('exam', 'question', 'questionTypes'));
    }

    public function update(Request $request, Exam $exam, Question $question)
    {
        // Dynamic validation rules based on question type
        $rules = [
            'content' => 'required|string',
            'type' => 'required|in:' . implode(',', QuestionTypeEnum::getConstants()),
            'points' => 'required|numeric|min:0.1',
            'options.*' => 'nullable|string',
        ];

        // Add conditional validation for correct_answer
        if ($request->type === QuestionTypeEnum::MULTIPLE_CHOICE) {
            $rules['correct_answer'] = 'required|string';
            $rules['options'] = 'required|array|min:2';
            $rules['options.*'] = 'required|string';
        } else {
            $rules['correct_answer'] = 'nullable|string';
        }

        $request->validate($rules);

        $questionData = [
            'content' => $request->content,
            'type' => $request->type,
            'points' => $request->points,
            'correct_answer' => $request->correct_answer,
        ];

        // Handle options for multiple choice questions
        if ($request->type === QuestionTypeEnum::MULTIPLE_CHOICE) {
            $options = array_filter($request->input('options', []));
            $questionData['options'] = $options;

            // Ensure correct_answer is one of the options (for multiple choice)
            if (!in_array($request->correct_answer, $options)) {
                return back()->withErrors(['correct_answer' => 'Đáp án đúng phải là một trong các tùy chọn được cung cấp.'])->withInput();
            }
        } else {
            $questionData['options'] = null;
        }

        $question->update($questionData);

        return redirect()->route('teacher.exams.questions.index', $exam->id)->with('success', __('site.updated_successfully'));
    }

    public function destroy(Exam $exam, Question $question)
    {
        $question->delete();
        if (request()->ajax()) {
            return response()->json([
                'success_message' => __('site.deleted_successfully')
            ]);
        }
        return redirect()->route('teacher.exams.questions.index', $exam->id)->with('success', __('site.deleted_successfully'));
    }
}
