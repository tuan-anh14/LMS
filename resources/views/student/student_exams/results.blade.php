@extends('layouts.student.app')

@section('content')

<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Kết quả bài kiểm tra</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('student.home') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('student.student_exams.index') }}">Bài kiểm tra</a></li>
                            <li class="breadcrumb-item active">Kết quả</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-chart-bar"></i> Kết quả bài kiểm tra: {{ $studentExam->exam->name }}</h4>
                        <div class="card-header-action">
                            <a href="{{ route('student.student_exams.show', $studentExam) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Thông tin tổng quan -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6><i class="fas fa-info-circle"></i> Thông tin bài thi</h6>
                                        <p class="mb-1"><strong>Bài kiểm tra:</strong> {{ $studentExam->exam->name }}</p>
                                        <p class="mb-1"><strong>Giáo viên:</strong> {{ $studentExam->teacher->name }}</p>
                                        <p class="mb-0"><strong>Giám khảo:</strong> {{ $studentExam->examiner->name }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6><i class="fas fa-calculator"></i> Điểm số</h6>
                                        @php
                                            $totalPossibleScore = $studentExam->exam->questions->sum('points') ?? $studentExam->exam->questions->count();
                                            $totalScore = $studentExam->answers->whereNotNull('score')->sum('score');
                                            $percentage = $totalPossibleScore > 0 ? ($totalScore / $totalPossibleScore * 100) : 0;
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
                                        <p class="mb-1"><strong>Điểm đạt được:</strong> 
                                            <span class="badge badge-primary">{{ $totalScore }}</span>
                                        </p>
                                        <p class="mb-1"><strong>Tổng điểm:</strong> 
                                            <span class="badge badge-secondary">{{ $totalPossibleScore }}</span>
                                        </p>
                                        <p class="mb-0"><strong>Phần trăm:</strong> 
                                            <span class="badge badge-{{ $percentage >= 80 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger') }}">
                                                {{ round($percentage, 1) }}%
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6><i class="fas fa-award"></i> Đánh giá</h6>
                                        @if($assessment)
                                            <div class="text-center">
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
                                            </div>
                                        @else
                                            <div class="text-center">
                                                <span class="badge badge-secondary">Chưa có đánh giá</span>
                                            </div>
                                        @endif
                                        @if($studentExam->notes && $studentExam->assessment)
                                            <div class="mt-2">
                                                
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chi tiết từng câu hỏi -->
                        @if($studentExam->answers->count() > 0)
                            <h5><i class="fas fa-list-alt"></i> Chi tiết bài làm</h5>
                            @foreach($studentExam->exam->questions as $question)
                                @php
                                    $answer = $studentExam->answers->where('question_id', $question->id)->first();
                                @endphp
                                <div class="card mb-3 border">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">
                                                <span class="badge badge-primary mr-2">{{ $loop->iteration }}</span>
                                                <span class="badge badge-{{ $question->isMultipleChoice() ? 'info' : 'warning' }} mr-2">
                                                    {{ $question->getTypeLabel() }}
                                                </span>
                                                <span class="badge badge-secondary">{{ $question->points ?? 1 }} điểm</span>
                                            </h6>
                                            
                                            @if($answer && $answer->score !== null)
                                                @php
                                                    $maxPoints = $question->points ?? 1;
                                                    $scorePercentage = ($answer->score / $maxPoints) * 100;
                                                @endphp
                                                <div>
                                                    <span class="badge badge-{{ $scorePercentage >= 80 ? 'success' : ($scorePercentage >= 50 ? 'warning' : 'danger') }}">
                                                        {{ $answer->score }}/{{ $maxPoints }} 
                                                        ({{ round($scorePercentage, 0) }}%)
                                                    </span>
                                                </div>
                                            @else
                                                <span class="badge badge-secondary">Chưa chấm điểm</span>
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
                                                                @php
                                                                    // Xác định đáp án đúng: nếu correct_answer là A/B/C/D thì lấy theo index, nếu là text thì so sánh nội dung
                                                                    $isCorrect = false;
                                                                    if (in_array($question->correct_answer, ['A','B','C','D'])) {
                                                                        $isCorrect = ($question->correct_answer === chr(65 + $index));
                                                                    } else {
                                                                        $isCorrect = ($question->correct_answer == $option);
                                                                    }
                                                                @endphp
                                                                <div class="mb-1">
                                                                    <span class="badge badge-light mr-1">{{ chr(65 + $index) }}.</span>
                                                                    <span class="@if($isCorrect) text-success font-weight-bold @endif">
                                                                        {{ $option }}
                                                                        @if($isCorrect)
                                                                            <i class="fas fa-check text-success ml-1"></i>
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    @if($answer)
                                                        @php
                                                            $studentAnswer = $answer->answer_text;
                                                            $studentLetter = '';
                                                            $studentDisplay = $studentAnswer;
                                                            $options = is_array($question->options) ? $question->options : [];
                                                            $optionsNorm = array_map(function($opt) {
                                                                return trim(mb_strtolower($opt));
                                                            }, $options);
                                                            $studentAnswerNorm = trim(mb_strtolower($studentAnswer));
                                                            $index = array_search($studentAnswerNorm, $optionsNorm, true);
                                                            if (in_array($studentAnswer, ['A','B','C','D'])) {
                                                                $studentLetter = $studentAnswer;
                                                                $studentDisplay = $studentLetter . (isset($options[ord($studentLetter)-65]) ? ' - ' . $options[ord($studentLetter)-65] : '');
                                                            } elseif ($index !== false) {
                                                                $studentLetter = chr(65 + $index);
                                                                $studentDisplay = "($studentLetter) " . $options[$index];
                                                            }
                                                            $isStudentCorrect = $studentLetter === $question->correct_answer;
                                                        @endphp
                                                        <div class="mb-3">
                                                            <strong>Lựa chọn của bạn:</strong>
                                                            <div class="alert {{ $isStudentCorrect ? 'alert-success' : 'alert-danger' }}">
                                                                <i class="fas {{ $isStudentCorrect ? 'fa-check' : 'fa-times' }}"></i>
                                                                {{ $studentDisplay }}
                                                                <span class="float-right badge badge-{{ $isStudentCorrect ? 'success' : 'danger' }}">
                                                                    {{ $isStudentCorrect ? 'Đúng' : 'Sai' }}
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <small class="text-muted">Đáp án đúng: <b>{{ $question->correct_answer }}</b></small>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <!-- Essay Question -->
                                            @if($question->correct_answer)
                                                <div class="mb-3">
                                                    <strong>Gợi ý đáp án:</strong>
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-lightbulb"></i>
                                                        {{ $question->correct_answer }}
                                                    </div>
                                                </div>
                                            @endif
                                            
                                            @if($answer)
                                                <div class="mb-3">
                                                    <strong>Câu trả lời của bạn:</strong>
                                                    <div class="alert alert-light border">
                                                        {{ $answer->answer_text }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                        @if($answer)
                                            @if($answer->comment)
                                                <div class="mt-3">
                                                    <strong>Nhận xét từ giám khảo:</strong>
                                                    <div class="alert alert-warning">
                                                        <i class="fas fa-comment"></i>
                                                        {{ $answer->comment }}
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="alert alert-danger">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                Bạn đã không trả lời câu hỏi này.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <!-- Tổng kết chi tiết -->
                            @php
                                $totalQuestions = $studentExam->exam->questions->count();
                                $answeredQuestions = $studentExam->answers->count();
                                $multipleChoiceQuestions = $studentExam->exam->questions->where('type', 'multiple_choice')->count();
                                $essayQuestions = $studentExam->exam->questions->where('type', 'essay')->count();
                                $correctMultipleChoice = 0;
                                
                                foreach($studentExam->exam->questions->where('type', 'multiple_choice') as $mcq) {
                                    $mcAnswer = $studentExam->answers->where('question_id', $mcq->id)->first();
                                    if($mcAnswer && $mcAnswer->answer_text == $mcq->correct_answer) {
                                        $correctMultipleChoice++;
                                    }
                                }
                            @endphp
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h5><i class="fas fa-chart-pie"></i> Thống kê chi tiết</h5>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-primary">{{ $answeredQuestions }}/{{ $totalQuestions }}</h4>
                                                <small class="text-muted">Câu đã trả lời</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-info">{{ $correctMultipleChoice }}/{{ $multipleChoiceQuestions }}</h4>
                                                <small class="text-muted">Trắc nghiệm đúng</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-warning">{{ $essayQuestions }}</h4>
                                                <small class="text-muted">Câu tự luận</small>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="text-center">
                                                <h4 class="text-success">{{ round($percentage, 1) }}%</h4>
                                                <small class="text-muted">Tỷ lệ đạt được</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                Không tìm thấy bài làm của bạn.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tự động chấm điểm trắc nghiệm
    const autoGradeBtn = document.getElementById('autoGradeBtn');
    if (autoGradeBtn) {
        autoGradeBtn.addEventListener('click', function() {
            document.querySelectorAll('.card').forEach(function(card) {
                const questionType = card.querySelector('.badge-info, .badge-warning');
                if (questionType && questionType.textContent.trim().toLowerCase().includes('trắc nghiệm')) {
                    const correct = card.querySelector('.text-success.font-weight-bold');
                    const student = card.querySelector('.alert');
                    const scoreInput = card.querySelector('input[type="number"]');
                    if (correct && student && scoreInput) {
                        if (student.classList.contains('alert-success')) {
                            scoreInput.value = scoreInput.getAttribute('max') || 1;
                        } else {
                            scoreInput.value = 0;
                        }
                    }
                }
            });
        });
    }
});
</script>
@endpush

@endsection 