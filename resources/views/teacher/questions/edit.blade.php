@extends('layouts.teacher.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('questions.edit_question') - {{ $exam->name }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teacher.exams.index') }}">@lang('exams.exams')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teacher.exams.questions.index', $exam->id) }}">@lang('questions.questions')</a></li>
                                <li class="breadcrumb-item active">@lang('site.edit')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('teacher.exams.questions.update', [$exam->id, $question->id]) }}" data-correct-answer="{{ $question->correct_answer }}">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Loại câu hỏi <span class="text-danger">*</span></label>
                                            <select name="type" id="question_type" class="form-control" required>
                                                <option value="">Chọn loại câu hỏi</option>
                                                @foreach($questionTypes as $value => $label)
                                                    <option value="{{ $value }}" {{ $question->type == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Điểm số <span class="text-danger">*</span></label>
                                            <input type="number" name="points" class="form-control" min="0.1" step="0.1" value="{{ $question->points ?? 1.0 }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>@lang('questions.content') <span class="text-danger">*</span></label>
                                    <textarea name="content" class="form-control" rows="3" required>{{ $question->content }}</textarea>
                                </div>

                                <!-- Multiple Choice Options -->
                                <div id="multiple_choice_section" style="display: {{ $question->isMultipleChoice() ? 'block' : 'none' }};">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Các đáp án trắc nghiệm <span class="text-danger">*</span></label>
                                        <div id="options_container">
                                            @php
                                                $options = $question->isMultipleChoice() && $question->options ? $question->options : ['', '', '', ''];
                                                $correctAnswer = $question->correct_answer ?? 'A';
                                            @endphp
                                            
                                            @for($i = 0; $i < 4; $i++)
                                                <div class="card mb-2 option-card" data-option="{{ chr(65 + $i) }}">
                                                    <div class="card-body py-2">
                                                        <div class="d-flex align-items-center">
                                                            <span class="option-letter bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" 
                                                                  style="width: 35px; height: 35px; font-weight: bold;">{{ chr(65 + $i) }}</span>
                                                            <input type="text" name="options[]" class="form-control option-input" 
                                                                   placeholder="Nhập nội dung đáp án {{ chr(65 + $i) }}" 
                                                                   value="{{ $options[$i] ?? '' }}" 
                                                                   {{ $question->isMultipleChoice() ? 'required' : '' }}>
                                                            <div class="ml-2">
                                                                <button type="button" class="btn btn-sm btn-outline-success correct-answer-btn" 
                                                                        data-answer="{{ chr(65 + $i) }}" 
                                                                        onclick="selectCorrectAnswer('{{ chr(65 + $i) }}')">
                                                                    <i class="fa fa-check"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa fa-info-circle"></i> 
                                            Nhập nội dung cho các đáp án và click nút tick để chọn đáp án đúng.
                                        </small>
                                    </div>
                                    
                                    <!-- Hidden input for correct answer -->
                                    <input type="hidden" name="correct_answer" id="correct_answer_input" value="{{ $correctAnswer }}">
                                    
                                    <div class="form-group">
                                        <label class="font-weight-bold">Đáp án đúng hiện tại: <span id="current_correct_answer" class="badge badge-success">{{ $correctAnswer }}</span></label>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fa fa-check-circle"></i> 
                                            Click vào nút tick bên cạnh đáp án để chọn đáp án đúng
                                        </small>
                                    </div>
                                </div>

                                <!-- Essay Answer Template -->
                                <div id="essay_section" style="display: {{ $question->isEssay() ? 'block' : 'none' }};">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Đáp án mẫu cho câu tự luận</label>
                                        <textarea name="correct_answer" class="form-control essay-answer" rows="4" placeholder="Nhập đáp án mẫu hoặc hướng dẫn chấm điểm cho câu tự luận..." {{ $question->isEssay() ? 'required' : '' }}>{{ $question->isEssay() ? $question->correct_answer : '' }}</textarea>
                                        <small class="text-muted">
                                            <i class="fa fa-lightbulb"></i> 
                                            Đáp án mẫu sẽ giúp examiner chấm điểm chính xác và nhất quán hơn
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i data-feather="save"></i> @lang('site.save')
                                    </button>
                                    <a href="{{ route('teacher.exams.questions.index', $exam->id) }}" class="btn btn-secondary btn-lg">
                                        <i data-feather="x"></i> @lang('site.cancel')
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .option-card.correct {
            border: 2px solid #28a745 !important;
            background-color: #f8fff9 !important;
        }
        
        .correct-answer-btn.active {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            color: white !important;
        }
        
        .correct-answer-btn:hover {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize correct answer highlighting
            const correctAnswer = document.querySelector('form').dataset.correctAnswer;
            if (correctAnswer) {
                selectCorrectAnswer(correctAnswer);
            }
            
            // Handle question type change
            document.getElementById('question_type').addEventListener('change', function() {
                toggleQuestionSections();
                syncCorrectAnswerInput();
            });
            
            // Khi submit form, đồng bộ correct_answer cho đúng loại
            document.querySelector('form').addEventListener('submit', function(e) {
                syncCorrectAnswerInput();
            });
            
            toggleQuestionSections();
            syncCorrectAnswerInput();
        });

        function selectCorrectAnswer(answer) {
            // Remove previous selection
            document.querySelectorAll('.option-card').forEach(card => {
                card.classList.remove('correct');
            });
            document.querySelectorAll('.correct-answer-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            
            // Add selection to current answer
            const selectedCard = document.querySelector(`[data-option="${answer}"]`);
            const selectedBtn = document.querySelector(`[data-answer="${answer}"]`);
            
            if (selectedCard && selectedBtn) {
                selectedCard.classList.add('correct');
                selectedBtn.classList.add('active');
                
                // Update hidden input and display
                document.getElementById('correct_answer_input').value = answer;
                document.getElementById('current_correct_answer').textContent = answer;
            }
        }

        function toggleQuestionSections() {
            const questionType = document.getElementById('question_type').value;
            const multipleChoiceSection = document.getElementById('multiple_choice_section');
            const essaySection = document.getElementById('essay_section');
            
            if (questionType === 'multiple_choice') {
                multipleChoiceSection.style.display = 'block';
                essaySection.style.display = 'none';
                
                // Make options required
                document.querySelectorAll('.option-input').forEach(input => {
                    input.setAttribute('required', 'required');
                });
                
                // Remove required from essay
                document.querySelector('.essay-answer').removeAttribute('required');
            } else if (questionType === 'essay') {
                multipleChoiceSection.style.display = 'none';
                essaySection.style.display = 'block';
                
                // Remove required from options
                document.querySelectorAll('.option-input').forEach(input => {
                    input.removeAttribute('required');
                });
                
                // Make essay required
                document.querySelector('.essay-answer').setAttribute('required', 'required');
            } else {
                multipleChoiceSection.style.display = 'none';
                essaySection.style.display = 'none';
                
                // Remove all required
                document.querySelectorAll('.option-input').forEach(input => {
                    input.removeAttribute('required');
                });
                document.querySelector('.essay-answer').removeAttribute('required');
            }
        }

        // Đảm bảo chỉ gửi đúng 1 correct_answer phù hợp loại câu hỏi
        function syncCorrectAnswerInput() {
            const questionType = document.getElementById('question_type').value;
            const hiddenInput = document.getElementById('correct_answer_input');
            const essayTextarea = document.querySelector('.essay-answer');
            if (questionType === 'multiple_choice') {
                if (hiddenInput) hiddenInput.disabled = false;
                if (essayTextarea) essayTextarea.disabled = true;
            } else if (questionType === 'essay') {
                if (hiddenInput) hiddenInput.disabled = true;
                if (essayTextarea) essayTextarea.disabled = false;
            } else {
                if (hiddenInput) hiddenInput.disabled = true;
                if (essayTextarea) essayTextarea.disabled = true;
            }
        }
    </script>
@endsection
