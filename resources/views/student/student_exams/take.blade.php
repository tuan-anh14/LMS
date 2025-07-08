@extends('layouts.student.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Làm bài kiểm tra: {{ $exam->name }}</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('student.home') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('student.student_exams.index') }}">Bài kiểm tra</a></li>
                            <li class="breadcrumb-item active">Làm bài</li>
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
                    <div class="card-header">
                        <h4 class="card-title">{{ $exam->name }}</h4>
                        <div class="float-right">
                            <span class="badge badge-info">
                                Tổng: {{ $exam->questions->sum('points') ?? $exam->questions->count() }} điểm
                            </span>
                            <span class="badge badge-secondary ml-1">
                                {{ $exam->questions->count() }} câu hỏi
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('student.student_exams.submit', $studentExam) }}" method="POST" id="examForm">
                            @csrf
                            
                            @foreach($exam->questions as $question)
                                <div class="question-block mb-4 p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="mb-0">
                                            <span class="badge badge-primary mr-2">{{ $loop->iteration }}</span>
                                            <span class="badge badge-{{ $question->isMultipleChoice() ? 'info' : 'warning' }} mr-2">
                                                {{ $question->getTypeLabel() }}
                                            </span>
                                            <span class="badge badge-secondary">{{ $question->points ?? 1 }} điểm</span>
                                        </h5>
                                    </div>
                                    
                                    <div class="question-content mb-3">
                                        <p class="lead">{{ $question->content }}</p>
                                    </div>

                                    @if($question->isMultipleChoice() && $question->options)
                                        <div class="answer-section">
                                            <p class="font-weight-bold mb-2">Chọn đáp án đúng:</p>
                                            @foreach($question->options as $index => $option)
                                                <div class="custom-control custom-radio mb-2">
                                                    <input type="radio" 
                                                           id="question_{{ $question->id }}_option_{{ $index }}" 
                                                           name="answers[{{ $question->id }}]" 
                                                           value="{{ chr(65 + $index) }}" 
                                                           class="custom-control-input" 
                                                           required>
                                                    <label class="custom-control-label" for="question_{{ $question->id }}_option_{{ $index }}">
                                                        <span class="option-letter mr-2">{{ chr(65 + $index) }}.</span>
                                                        {{ $option }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="answer-section">
                                            <label class="font-weight-bold mb-2">Câu trả lời của bạn:</label>
                                            <textarea name="answers[{{ $question->id }}]" 
                                                     class="form-control" 
                                                     rows="4" 
                                                     placeholder="Nhập câu trả lời chi tiết..." 
                                                     required></textarea>
                                            <small class="text-muted">Trả lời chi tiết và rõ ràng để được điểm tối đa</small>
                                        </div>
                                    @endif
                                </div>
                            @endforeach

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Bạn có chắc chắn muốn nộp bài? Sau khi nộp sẽ không thể chỉnh sửa.')">
                                    <i class="fa fa-paper-plane mr-2"></i>
                                    Nộp bài kiểm tra
                                </button>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        Hãy kiểm tra kỹ trước khi nộp bài. Bạn sẽ không thể sửa đổi sau khi nộp.
                                    </small>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Progress tracking
    function updateProgress() {
        var totalQuestions = $('.question-block').length;
        var answeredQuestions = 0;
        
        $('.question-block').each(function() {
            var hasAnswer = false;
            
            // Check radio buttons
            if ($(this).find('input[type="radio"]:checked').length > 0) {
                hasAnswer = true;
            }
            
            // Check textareas
            if ($(this).find('textarea').val().trim() !== '') {
                hasAnswer = true;
            }
            
            if (hasAnswer) {
                answeredQuestions++;
                $(this).removeClass('border-warning').addClass('border-success');
            } else {
                $(this).removeClass('border-success').addClass('border-warning');
            }
        });
        
        var progress = (answeredQuestions / totalQuestions) * 100;
        console.log(`Progress: ${answeredQuestions}/${totalQuestions} (${progress.toFixed(1)}%)`);
    }
    
    // Update progress on input change
    $('input[type="radio"], textarea').on('change input', updateProgress);
    
    // Initial progress check
    updateProgress();
    
    // Form validation before submit
    $('#examForm').on('submit', function(e) {
        var unanswered = [];
        
        $('.question-block').each(function(index) {
            var questionNum = index + 1;
            var hasAnswer = false;
            
            // Check radio buttons
            if ($(this).find('input[type="radio"]:checked').length > 0) {
                hasAnswer = true;
            }
            
            // Check textareas
            if ($(this).find('textarea').val().trim() !== '') {
                hasAnswer = true;
            }
            
            if (!hasAnswer) {
                unanswered.push(questionNum);
            }
        });
        
        if (unanswered.length > 0) {
            e.preventDefault();
            alert('Bạn chưa trả lời câu hỏi số: ' + unanswered.join(', ') + '. Vui lòng hoàn thành tất cả câu hỏi trước khi nộp bài.');
            return false;
        }
    });
});
</script>
@endsection 