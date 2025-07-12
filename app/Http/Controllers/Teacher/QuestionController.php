<?php

namespace App\Http\Controllers\Teacher;

use App\Enums\QuestionTypeEnum;
use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use Exception;

class QuestionController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    /**
     * Kiểm tra xem bài kiểm tra có thuộc project mà giảng viên đang dạy không
     */
    private function checkExamAuthorization(Exam $exam)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if (!$user->teachesProject($exam->project_id)) {
            abort(403, 'Bạn không có quyền quản lý câu hỏi cho bài kiểm tra này.');
        }
    }

    public function index(Exam $exam)
    {
        $this->checkExamAuthorization($exam);
        
        $questions = $exam->questions;
        return view('teacher.questions.index', compact('exam', 'questions'));
    }

    public function create(Exam $exam)
    {
        $this->checkExamAuthorization($exam);
        
        $questionTypes = QuestionTypeEnum::getLabels();
        return view('teacher.questions.create', compact('exam', 'questionTypes'));
    }

    public function store(Request $request, Exam $exam)
    {
        $this->checkExamAuthorization($exam);
        
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
            
            // Add custom validation for unique options
            $request->validate($rules);
            
            // Check for duplicate options
            $options = array_filter($request->input('options', []));
            $uniqueOptions = array_unique($options);
            
            if (count($options) !== count($uniqueOptions)) {
                return back()->withErrors(['options' => 'Các đáp án không được trùng nhau.'])->withInput();
            }
        } else {
            $request->validate($rules);
        }

        $questionData = [
            'content' => $request->content,
            'type' => $request->type,
            'points' => $request->points,
        ];

        // Handle options for multiple choice questions
        if ($request->type === QuestionTypeEnum::MULTIPLE_CHOICE) {
            $options = array_filter($request->input('options', []));
            $questionData['options'] = $options;

            // Convert letter answer (A, B, C, D) to actual option content
            $correctAnswerLetter = $request->correct_answer;
            $correctAnswerIndex = ord($correctAnswerLetter) - ord('A'); // Convert A=0, B=1, C=2, D=3
            
            if (isset($options[$correctAnswerIndex])) {
                $questionData['correct_answer'] = $options[$correctAnswerIndex];
            } else {
                return back()->withErrors(['correct_answer' => 'Đáp án đúng không hợp lệ.'])->withInput();
            }
        } else {
            $questionData['options'] = null;
            $questionData['correct_answer'] = $request->correct_answer;
        }

        $exam->questions()->create($questionData);

        return redirect()->route('teacher.exams.questions.index', $exam->id)->with('success', __('site.added_successfully'));
    }

    public function edit(Exam $exam, Question $question)
    {
        $this->checkExamAuthorization($exam);
        
        $questionTypes = QuestionTypeEnum::getLabels();
        return view('teacher.questions.edit', compact('exam', 'question', 'questionTypes'));
    }

    public function update(Request $request, Exam $exam, Question $question)
    {
        $this->checkExamAuthorization($exam);
        
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
            
            // Add custom validation for unique options
            $request->validate($rules);
            
            // Check for duplicate options
            $options = array_filter($request->input('options', []));
            $uniqueOptions = array_unique($options);
            
            if (count($options) !== count($uniqueOptions)) {
                return back()->withErrors(['options' => 'Các đáp án không được trùng nhau.'])->withInput();
            }
        } else {
            $request->validate($rules);
        }

        $questionData = [
            'content' => $request->content,
            'type' => $request->type,
            'points' => $request->points,
        ];

        // Handle options for multiple choice questions
        if ($request->type === QuestionTypeEnum::MULTIPLE_CHOICE) {
            $options = array_filter($request->input('options', []));
            $questionData['options'] = $options;

            // Convert letter answer (A, B, C, D) to actual option content
            $correctAnswerLetter = $request->correct_answer;
            $correctAnswerIndex = ord($correctAnswerLetter) - ord('A'); // Convert A=0, B=1, C=2, D=3
            
            if (isset($options[$correctAnswerIndex])) {
                $questionData['correct_answer'] = $options[$correctAnswerIndex];
            } else {
                return back()->withErrors(['correct_answer' => 'Đáp án đúng không hợp lệ.'])->withInput();
            }
        } else {
            $questionData['options'] = null;
            $questionData['correct_answer'] = $request->correct_answer;
        }

        $question->update($questionData);

        return redirect()->route('teacher.exams.questions.index', $exam->id)->with('success', __('site.updated_successfully'));
    }

    public function destroy(Exam $exam, Question $question)
    {
        $this->checkExamAuthorization($exam);
        
        $question->delete();
        if (request()->ajax()) {
            return response()->json([
                'success_message' => __('site.deleted_successfully')
            ]);
        }
        return redirect()->route('teacher.exams.questions.index', $exam->id)->with('success', __('site.deleted_successfully'));
    }

    /**
     * Show form to generate questions using AI
     */
    public function createWithAI(Exam $exam)
    {
        $this->checkExamAuthorization($exam);
        
        return view('teacher.questions.create_with_ai', compact('exam'));
    }

    /**
     * Generate questions using AI
     */
    public function generateWithAI(Request $request, Exam $exam)
    {
        $this->checkExamAuthorization($exam);
        
        $request->validate([
            'topic' => 'required|string|max:255',
            'count' => 'required|integer|min:1|max:' . config('services.openai.max_questions', 10),
            'difficulty' => 'required|in:easy,medium,hard',
            'type' => 'required|in:multiple_choice,essay,mixed',
        ]);

        try {
            $questions = $this->openAIService->generateQuestions(
                $request->topic,
                $request->count,
                $request->difficulty,
                $request->type
            );

            if (empty($questions)) {
                return back()->withErrors(['ai_error' => 'Không thể tạo câu hỏi. Vui lòng thử lại với chủ đề khác.'])->withInput();
            }

            // Store questions in session for preview
            session(['generated_questions' => $questions, 'exam_id' => $exam->id]);

            return redirect()->route('teacher.exams.questions.preview_ai', $exam->id)
                ->with('success', 'Đã tạo thành công ' . count($questions) . ' câu hỏi. Vui lòng xem lại và xác nhận.');
        } catch (Exception $e) {
            return back()->withErrors(['ai_error' => 'Lỗi khi tạo câu hỏi: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Preview AI generated questions before saving
     */
    public function previewAI(Exam $exam)
    {
        $this->checkExamAuthorization($exam);
        
        $questions = session('generated_questions');
        $sessionExamId = session('exam_id');

        if (!$questions || $sessionExamId != $exam->id) {
            return redirect()->route('teacher.exams.questions.create_ai', $exam->id)
                ->withErrors(['preview_error' => 'Không tìm thấy câu hỏi đã tạo. Vui lòng tạo lại.']);
        }

        return view('teacher.questions.preview_ai', compact('exam', 'questions'));
    }

    /**
     * Save AI generated questions to database
     */
    public function saveAI(Request $request, Exam $exam)
    {
        $this->checkExamAuthorization($exam);
        
        $questions = session('generated_questions');
        $sessionExamId = session('exam_id');

        if (!$questions || $sessionExamId != $exam->id) {
            return redirect()->route('teacher.exams.questions.create_ai', $exam->id)
                ->withErrors(['save_error' => 'Không tìm thấy câu hỏi đã tạo. Vui lòng tạo lại.']);
        }

        $request->validate([
            'selected_questions' => 'required|array|min:1',
            'selected_questions.*' => 'integer|min:0',
        ]);

        $savedCount = 0;
        foreach ($request->selected_questions as $index) {
            if (isset($questions[$index])) {
                $questionData = $questions[$index];
                $exam->questions()->create($questionData);
                $savedCount++;
            }
        }

        // Clear session data
        session()->forget(['generated_questions', 'exam_id']);

        return redirect()->route('teacher.exams.questions.index', $exam->id)
            ->with('success', "Đã lưu thành công {$savedCount} câu hỏi vào bài kiểm tra.");
    }

    /**
     * Cancel AI generation and clear session
     */
    public function cancelAI(Exam $exam)
    {
        $this->checkExamAuthorization($exam);
        
        session()->forget(['generated_questions', 'exam_id']);
        return redirect()->route('teacher.exams.questions.index', $exam->id);
    }
}
