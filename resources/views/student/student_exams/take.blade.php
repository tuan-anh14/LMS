@extends('layouts.student.app')
@section('content')
<div class="container">
    <h2>Làm bài kiểm tra: {{ $exam->name }}</h2>
    <form action="{{ route('student.student_exams.submit', $studentExam) }}" method="POST">
        @csrf
        @foreach($exam->questions as $question)
            <div class="mb-3">
                <label><b>Câu hỏi {{ $loop->iteration }}:</b> {{ $question->content }}</label>
                @if($question->type === 'multiple_choice' && $question->options)
                    @php $options = json_decode($question->options, true); @endphp
                    @foreach($options as $opt)
                        <div>
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $opt }}" required> {{ $opt }}
                        </div>
                    @endforeach
                @else
                    <textarea name="answers[{{ $question->id }}]" class="form-control" rows="2" required></textarea>
                @endif
            </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Nộp bài</button>
    </form>
</div>
@endsection 