@extends('layouts.teacher.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">@lang('questions.questions') - {{ $exam->name }}</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('teacher.exams.index') }}">@lang('exams.exams')</a></li>
                            <li class="breadcrumb-item active">@lang('questions.questions')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('teacher.exams.questions.create', $exam->id) }}" class="btn btn-primary waves-effect waves-float waves-light">
                            <i data-feather="plus"></i> @lang('questions.new_question')
                        </a>
                        <a href="{{ route('teacher.exams.questions.create_ai', $exam->id) }}" class="btn btn-gradient-success waves-effect waves-float waves-light ml-2">
                            <i class="fas fa-robot mr-1"></i> Tạo câu hỏi bằng AI
                        </a>
                    </div>
                    @if($questions->count() > 0)
                    <div class="text-muted">
                        <i class="fas fa-info-circle mr-1"></i>
                        Tổng cộng <span class="font-weight-bold text-primary">{{ $questions->count() }}</span> câu hỏi
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="50%">@lang('questions.content')</th>
                                    <th width="15%">Loại</th>
                                    <th width="10%">Điểm</th>
                                    <th width="20%">@lang('site.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($questions as $question)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="question-content">
                                            {{ Str::limit($question->content, 100) }}
                                        </div>
                                        @if($question->isMultipleChoice() && $question->options)
                                        <div class="mt-2">
                                            <small class="text-muted">Lựa chọn:</small>
                                            <ul class="list-unstyled ml-2">
                                                @foreach($question->options as $option)
                                                <li class="small text-muted">
                                                    • {{ $option }}
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $question->isMultipleChoice() ? 'info' : 'warning' }}">
                                            {{ $question->getTypeLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-secondary">{{ $question->points ?? 1 }} điểm</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('teacher.exams.questions.edit', [$exam->id, $question->id]) }}" class="btn btn-sm btn-warning">@lang('site.edit')</a>
                                        <form action="{{ route('teacher.exams.questions.destroy', [$exam->id, $question->id]) }}" method="POST" style="display:inline-block" class="ajax-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete">@lang('site.delete')</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                @if($questions->count() == 0)
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Chưa có câu hỏi nào</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                        @if($questions->count() > 0)
                        <div class="mt-3">
                            <div class="alert alert-info">
                                <strong>Thống kê:</strong>
                                Tổng cộng {{ $questions->count() }} câu hỏi
                                | Tổng điểm: {{ $questions->sum('points') ?? $questions->count() }} điểm
                                | Trắc nghiệm: {{ $questions->where('type', 'multiple_choice')->count() }} câu
                                | Tự luận: {{ $questions->where('type', 'essay')->count() }} câu
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .btn-gradient-success {
        background: linear-gradient(45deg, #28c76f, #48da89);
        border: none;
        box-shadow: 0 4px 18px 0 rgba(40, 199, 111, 0.4);
        color: white;
    }

    .btn-gradient-success:hover {
        background: linear-gradient(45deg, #20be5f, #28c76f);
        box-shadow: 0 8px 25px 0 rgba(40, 199, 111, 0.6);
        transform: translateY(-2px);
        color: white;
    }

    .waves-effect {
        position: relative;
        cursor: pointer;
        overflow: hidden;
    }
</style>
@endpush