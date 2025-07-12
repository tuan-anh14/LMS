@extends('layouts.examiner.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Chấm điểm bài kiểm tra</h4>
                <div class="card-header-action">
                    <a href="{{ route('examiner.student_exams.show', $studentExam) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Thông tin bài thi -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <strong>Sinh viên:</strong> {{ $studentExam->student->name }}<br>
                        <strong>Bài kiểm tra:</strong> {{ $studentExam->exam->name }}<br>
                    </div>
                    <div class="col-md-4">
                        <strong>Thời gian nộp:</strong> 
                        @if($studentExam->answers->first())
                            {{ $studentExam->answers->first()->submitted_at->format('H:i d/m/Y') }}
                        @else
                            Chưa nộp bài
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="text-right">
                            <button type="button" id="autoGradeBtn" class="btn btn-info btn-sm">
                                <i class="fas fa-magic"></i> Tự động chấm trắc nghiệm
                            </button>
                        </div>
                    </div>
                </div>

                @if($studentExam->answers->count() > 0)
                <form action="{{ route('examiner.student_exams.update_grade', $studentExam) }}" method="POST" id="gradingForm">
                    @csrf
                    @method('PUT')

                    <!-- Danh sách câu hỏi và đáp án -->
                    @foreach($studentExam->exam->questions as $question)
                        @php
                            $answer = $studentExam->answers->where('question_id', $question->id)->first();
                        @endphp
                        <div class="card mb-3 question-card" data-question-type="{{ $question->type }}" data-correct-answer="{{ $question->correct_answer }}" data-points="{{ $question->points ?? 1 }}">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <span class="badge badge-primary mr-2">{{ $loop->iteration }}</span>
                                        <span class="badge badge-{{ $question->isMultipleChoice() ? 'info' : 'warning' }} mr-2">
                                            {{ $question->getTypeLabel() }}
                                        </span>
                                        <span class="badge badge-secondary">{{ $question->points ?? 1 }} điểm</span>
                                    </h6>
                                    @if($question->isMultipleChoice())
                                        <span class="text-muted small">Tự động chấm</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="question-content mb-3">
                                    <strong>Câu hỏi:</strong> {{ $question->content }}
                                </div>
                                
                                @if($question->isMultipleChoice() && $question->options)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <strong>Các lựa chọn:</strong>
                                                <div class="mt-2">
                                                    @foreach($question->options as $index => $option)
                                                        <div class="mb-1">
                                                            <span class="badge badge-light">{{ chr(65 + $index) }}.</span>
                                                            <span class="{{ $question->correct_answer == $option ? 'text-success font-weight-bold' : '' }}">
                                                                {{ $option }}
                                                                @if($question->correct_answer == $option)
                                                                    <i class="fas fa-check text-success ml-1"></i>
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                            @if($question->correct_answer)
                                                <div class="alert alert-success">
                                                    <strong><i class="fas fa-check-circle"></i> Đáp án đúng:</strong> 
                                                    {{ $question->correct_answer }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="col-md-6">
                                            @if($answer)
                                                <div class="mb-3">
                                                    <strong>Lựa chọn của sinh viên:</strong>
                                                    <div class="alert {{ ($answer->answer_text == $question->correct_answer) ? 'alert-success' : 'alert-danger' }}">
                                                        <i class="fas {{ ($answer->answer_text == $question->correct_answer) ? 'fa-check' : 'fa-times' }}"></i>
                                                        {{ $answer->answer_text }}
                                                        @if($answer->answer_text == $question->correct_answer)
                                                            <span class="float-right badge badge-success">Đúng</span>
                                                        @else
                                                            <span class="float-right badge badge-danger">Sai</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <!-- Essay Question -->
                                    @if($question->correct_answer)
                                        <div class="mb-3">
                                            <strong>Đáp án mẫu/Hướng dẫn chấm:</strong>
                                            <div class="alert alert-info">
                                                <i class="fas fa-lightbulb"></i>
                                                {{ $question->correct_answer }}
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                @if($answer)
                                    @if($question->isEssay())
                                        <div class="mb-3">
                                            <strong>Câu trả lời của sinh viên:</strong>
                                            <div class="alert alert-light border">
                                                {{ $answer->answer_text }}
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="row grading-section">
                                        <div class="col-md-4">
                                            <label for="score_{{ $answer->id }}">Điểm số (tối đa {{ $question->points ?? 1 }}):</label>
                                            <input type="number" 
                                                   name="scores[{{ $answer->id }}]" 
                                                   id="score_{{ $answer->id }}"
                                                   class="form-control score-input" 
                                                   value="{{ $answer->score ?? 0 }}"
                                                   min="0" 
                                                   max="{{ $question->points ?? 1 }}"
                                                   step="0.1" 
                                                   placeholder="0"
                                                   data-max-points="{{ $question->points ?? 1 }}">
                                        </div>
                                        <div class="col-md-8">
                                            <label for="comment_{{ $answer->id }}">Nhận xét:</label>
                                            <textarea name="comments[{{ $answer->id }}]" 
                                                      id="comment_{{ $answer->id }}"
                                                      class="form-control" 
                                                      rows="2" 
                                                      placeholder="Nhận xét cho sinh viên...">{{ $answer->comment }}</textarea>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        Sinh viên chưa trả lời câu hỏi này.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Tổng kết -->
                    @php
                        $totalScore = $studentExam->answers->whereNotNull('score')->sum('score');
                        $maxScore = $studentExam->exam->questions->sum('points') ?? $studentExam->exam->questions->count();
                        $percentage = $maxScore > 0 ? ($totalScore / $maxScore * 100) : 0;
                        $assessment = $studentExam->assessment;
                        // Chỉ đánh giá khi đã làm bài (có câu trả lời)
                        $hasAnswers = $studentExam->answers->whereNotNull('answer_text')->count() > 0;
                        if (!$assessment && $hasAnswers) {
                            if ($percentage >= 90) $assessment = 'superiority';
                            elseif ($percentage >= 80) $assessment = 'excellent';
                            elseif ($percentage >= 70) $assessment = 'very_good';
                            elseif ($percentage >= 60) $assessment = 'good';
                            else $assessment = 'repeat';
                        }
                    @endphp
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5><i class="fas fa-chart-line"></i> Đánh giá tổng thể</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <p class="mb-1"><strong>Điểm đạt được:</strong>
                                        <span class="badge badge-primary">{{ $totalScore }}</span>
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-1"><strong>Tổng điểm:</strong>
                                        <span class="badge badge-secondary">{{ $maxScore }}</span>
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-1"><strong>Phần trăm:</strong>
                                        <span class="badge badge-{{ $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger') }}">{{ round($percentage, 1) }}%</span>
                                    </p>
                                </div>
                                <div class="col-md-3">
                                    <p class="mb-1"><strong>Đánh giá:</strong>
                                        @if($assessment)
                                            <span class="badge badge-lg badge-
                                                @if($assessment === 'excellent') success
                                                @elseif(in_array($assessment, ['very_good', 'good'])) primary
                                                @elseif($assessment === 'average') warning
                                                @else danger @endif
                                            " style="color: #6e6b7b; font-weight: 600;">
                                                @switch($assessment)
                                                    @case('excellent') <i class="fas fa-star"></i> Xuất sắc @break
                                                    @case('very_good') <i class="fas fa-thumbs-up"></i> Rất tốt @break
                                                    @case('good') <i class="fas fa-check"></i> Tốt @break
                                                    @case('average') <i class="fas fa-equals"></i> Trung bình @break
                                                    @case('below_average') <i class="fas fa-arrow-down"></i> Dưới trung bình @break
                                                    @case('poor') <i class="fas fa-times"></i> Kém @break
                                                    @default {{ $assessment }}
                                                @endswitch
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">Chưa có đánh giá</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-save"></i> Lưu kết quả chấm điểm
                        </button>
                    </div>
                </form>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        Sinh viên chưa nộp bài kiểm tra này.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
$(document).ready(function() {
    // Auto calculate total score and percentage
    function calculateTotalScore() {
        let total = 0;
        let maxTotal = parseFloat($('#max_score').val()) || 0;
        
        $('.score-input').each(function() {
            let value = parseFloat($(this).val()) || 0;
            total += value;
        });
        
        $('#total_score').val(total.toFixed(1));
        
        if (maxTotal > 0) {
            let percentage = (total / maxTotal * 100).toFixed(1);
            $('#percentage').val(percentage + '%');
            
            // Auto suggest assessment based on percentage
            let percentageNum = parseFloat(percentage);
            let assessment = '';
            
            if (percentageNum >= 90) assessment = 'excellent';
            else if (percentageNum >= 80) assessment = 'very_good';
            else if (percentageNum >= 70) assessment = 'good';
            else if (percentageNum >= 60) assessment = 'average';
            else if (percentageNum >= 50) assessment = 'below_average';
            else assessment = 'poor';
            
            $('#assessment').val(assessment);
        }
    }
    
    // Validate score input
    $('.score-input').on('input', function() {
        let maxPoints = parseFloat($(this).data('max-points')) || 1;
        let currentValue = parseFloat($(this).val()) || 0;
        
        if (currentValue > maxPoints) {
            $(this).val(maxPoints);
            alert('Điểm số không được vượt quá ' + maxPoints + ' điểm');
        }
        
        calculateTotalScore();
    });
    
    // Auto grade multiple choice questions
    $('#autoGradeBtn').click(function() {
        let gradedCount = 0;
        
        $('.question-card').each(function() {
            let questionType = $(this).data('question-type');
            let correctAnswer = $(this).data('correct-answer');
            let points = parseFloat($(this).data('points')) || 1;
            
            if (questionType === 'multiple_choice' && correctAnswer) {
                let studentAnswer = $(this).find('.alert-success, .alert-danger').text().trim();
                let scoreInput = $(this).find('.score-input');
                
                if (studentAnswer.includes(correctAnswer)) {
                    scoreInput.val(points);
                    gradedCount++;
                } else if (studentAnswer && !studentAnswer.includes('Sinh viên chưa trả lời')) {
                    scoreInput.val(0);
                    gradedCount++;
                }
            }
        });
        
        if (gradedCount > 0) {
            calculateTotalScore();
            alert('Đã tự động chấm ' + gradedCount + ' câu trắc nghiệm!');
        } else {
            alert('Không tìm thấy câu trắc nghiệm nào để chấm tự động.');
        }
    });
    
    // Initial calculation
    calculateTotalScore();
    // Đảm bảo cập nhật tổng kết khi trang vừa load (fix trường hợp input bị để trống)
    $(window).on('load', function() {
        calculateTotalScore();
    });
    // --- DEBUG: Log giá trị tổng kết khi load trang ---
    setTimeout(function() {
        console.log('DEBUG: total_score =', $('#total_score').val());
        console.log('DEBUG: percentage =', $('#percentage').val());
        console.log('DEBUG: assessment =', $('#assessment').val());
        // Nếu input bị readonly mà value không hiện, ép cập nhật lại UI
        $('#total_score')[0].value = $('#total_score').val();
        $('#percentage')[0].value = $('#percentage').val();
    }, 500);
    
    // Form validation
    $('#gradingForm').on('submit', function(e) {
        let hasUngraded = false;
        let ungradedQuestions = [];
        
        $('.score-input').each(function(index) {
            let value = $(this).val();
            if (!value || value === '' || parseFloat(value) < 0) {
                hasUngraded = true;
                ungradedQuestions.push(index + 1);
            }
        });
        
        if (hasUngraded) {
            if (ungradedQuestions.length > 0) {
                var n = new Noty({
                    text: 'Bạn chưa chấm điểm cho câu hỏi số: ' + ungradedQuestions.join(', ') + '. Bạn có muốn tiếp tục không?',
                    type: 'alert',
                    killer: true,
                    timeout: 2000
                });
                n.show();
            } else {
                // ... tiếp tục xử lý nếu không có câu hỏi chưa chấm
            }
        }
    });
});
</script>
@endpush 