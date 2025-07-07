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
                    <div class="col-md-6">
                        <strong>Học sinh:</strong> {{ $studentExam->student->name }}<br>
                        <strong>Bài kiểm tra:</strong> {{ $studentExam->exam->name }}<br>
                    </div>
                    <div class="col-md-6">
                        <strong>Thời gian nộp:</strong> 
                        @if($studentExam->answers->first())
                            {{ $studentExam->answers->first()->submitted_at->format('H:i:s d/m/Y') }}
                        @else
                            Chưa nộp bài
                        @endif
                    </div>
                </div>

                @if($studentExam->answers->count() > 0)
                <form action="{{ route('examiner.student_exams.update_grade', $studentExam) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Danh sách câu hỏi và đáp án -->
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
                                            <label><strong>Câu trả lời của học sinh:</strong></label>
                                            <div class="alert alert-info">
                                                {{ $answer->answer_text }}
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="score_{{ $answer->id }}">Điểm số:</label>
                                            <input type="number" 
                                                   name="scores[{{ $answer->id }}]" 
                                                   id="score_{{ $answer->id }}"
                                                   class="form-control" 
                                                   value="{{ $answer->score }}"
                                                   min="0" 
                                                   step="0.1" 
                                                   placeholder="0">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="comment_{{ $answer->id }}">Nhận xét:</label>
                                            <textarea name="comments[{{ $answer->id }}]" 
                                                      id="comment_{{ $answer->id }}"
                                                      class="form-control" 
                                                      rows="2" 
                                                      placeholder="Nhận xét...">{{ $answer->comment }}</textarea>
                                        </div>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        Học sinh chưa trả lời câu hỏi này.
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Tổng kết -->
                    <div class="card">
                        <div class="card-body">
                            <h5>Đánh giá tổng thể</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="total_score">Tổng điểm:</label>
                                    <input type="number" 
                                           name="total_score" 
                                           id="total_score"
                                           class="form-control" 
                                           min="0" 
                                           step="0.1" 
                                           placeholder="Điểm tổng">
                                </div>
                                <div class="col-md-6">
                                    <label for="assessment">Đánh giá:</label>
                                    <select name="assessment" id="assessment" class="form-control">
                                        <option value="">Chọn đánh giá</option>
                                        <option value="excellent" {{ $studentExam->assessment === 'excellent' ? 'selected' : '' }}>Xuất sắc</option>
                                        <option value="good" {{ $studentExam->assessment === 'good' ? 'selected' : '' }}>Tốt</option>
                                        <option value="average" {{ $studentExam->assessment === 'average' ? 'selected' : '' }}>Trung bình</option>
                                        <option value="below_average" {{ $studentExam->assessment === 'below_average' ? 'selected' : '' }}>Dưới trung bình</option>
                                        <option value="poor" {{ $studentExam->assessment === 'poor' ? 'selected' : '' }}>Kém</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Lưu kết quả chấm điểm
                        </button>
                    </div>
                </form>
                @else
                    <div class="alert alert-warning">
                        Học sinh chưa nộp bài kiểm tra này.
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
    // Auto calculate total score
    $('input[name^="scores"]').on('input', function() {
        let total = 0;
        $('input[name^="scores"]').each(function() {
            let value = parseFloat($(this).val()) || 0;
            total += value;
        });
        $('#total_score').val(total.toFixed(1));
    });
});
</script>
@endpush 