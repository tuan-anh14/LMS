@extends('layouts.student.app')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Kết quả bài kiểm tra</h4>
                <div class="card-header-action">
                    <a href="{{ route('student.student_exams.show', $studentExam) }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Thông tin tổng quan -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Thông tin bài thi</h5>
                        <p><strong>Bài kiểm tra:</strong> {{ $studentExam->exam->name }}</p>
                        <p><strong>Giáo viên:</strong> {{ $studentExam->teacher->name }}</p>
                        <p><strong>Giám khảo:</strong> {{ $studentExam->examiner->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>Kết quả</h5>
                        @if($studentExam->notes)
                            <p><strong>{{ $studentExam->notes }}</strong></p>
                        @endif
                        @if($studentExam->assessment)
                            <p><strong>Đánh giá:</strong> 
                                <span class="badge badge-
                                    @if($studentExam->assessment === 'excellent') success 
                                    @elseif($studentExam->assessment === 'good') primary
                                    @elseif($studentExam->assessment === 'average') warning
                                    @else danger @endif
                                ">
                                    @switch($studentExam->assessment)
                                        @case('excellent') Xuất sắc @break
                                        @case('good') Tốt @break
                                        @case('average') Trung bình @break
                                        @case('below_average') Dưới trung bình @break
                                        @case('poor') Kém @break
                                        @default {{ $studentExam->assessment }}
                                    @endswitch
                                </span>
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Chi tiết từng câu hỏi -->
                @if($studentExam->answers->count() > 0)
                    <h5>Chi tiết bài làm</h5>
                    @foreach($studentExam->exam->questions as $question)
                        @php
                            $answer = $studentExam->answers->where('question_id', $question->id)->first();
                        @endphp
                        <div class="card mb-3">
                            <div class="card-body">
                                <h6><strong>Câu {{ $loop->iteration }}:</strong> {{ $question->content }}</h6>
                                
                                @if($question->type === 'multiple_choice' && $question->options)
                                    @php $options = json_decode($question->options, true); @endphp
                                    <div class="mb-2">
                                        <strong>Các lựa chọn:</strong>
                                        @foreach($options as $opt)
                                            <span class="badge badge-light">{{ $opt }}</span>
                                        @endforeach
                                    </div>
                                    @if($question->correct_answer)
                                        <div class="mb-2">
                                            <strong>Đáp án đúng:</strong> 
                                            <span class="badge badge-success">{{ $question->correct_answer }}</span>
                                        </div>
                                    @endif
                                @endif

                                @if($answer)
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label><strong>Câu trả lời của bạn:</strong></label>
                                            <div class="alert alert-info">
                                                {{ $answer->answer_text }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            @if($answer->score !== null)
                                                <label><strong>Điểm số:</strong></label>
                                                <div class="alert alert-
                                                    @if($answer->score >= 8) success
                                                    @elseif($answer->score >= 5) warning  
                                                    @else danger @endif
                                                ">
                                                    {{ $answer->score }} điểm
                                                </div>
                                            @else
                                                <div class="alert alert-secondary">
                                                    Chưa chấm điểm
                                                </div>
                                            @endif
                                        </div>
                                        <div class="col-md-3">
                                            @if($answer->comment)
                                                <label><strong>Nhận xét:</strong></label>
                                                <div class="alert alert-light">
                                                    {{ $answer->comment }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        Bạn đã không trả lời câu hỏi này.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Tổng kết điểm -->
                    @php
                        $totalQuestions = $studentExam->exam->questions->count();
                        $totalScore = $studentExam->answers->whereNotNull('score')->sum('score');
                        $answeredQuestions = $studentExam->answers->count();
                    @endphp
                    <div class="card">
                        <div class="card-body">
                            <h5>Tổng kết</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Số câu đã trả lời:</strong> {{ $answeredQuestions }}/{{ $totalQuestions }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Tổng điểm:</strong> {{ $totalScore }} điểm
                                </div>
                                <div class="col-md-4">
                                    <strong>Điểm trung bình:</strong> 
                                    @if($answeredQuestions > 0)
                                        {{ round($totalScore / $answeredQuestions, 1) }} điểm
                                    @else
                                        0 điểm
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning">
                        Không tìm thấy bài làm của bạn.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection 