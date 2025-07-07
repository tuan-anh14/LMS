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
                    <a href="{{ route('teacher.exams.questions.create', $exam->id) }}" class="btn btn-primary">
                        <i data-feather="plus"></i> @lang('questions.new_question')
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>@lang('questions.content')</th>
                                        <th>@lang('site.action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                        <tr>
                                            <td>{{ $question->content }}</td>
                                            <td>
                                                <a href="{{ route('teacher.exams.questions.edit', [$exam->id, $question->id]) }}" class="btn btn-sm btn-warning">@lang('site.edit')</a>
                                                <form action="{{ route('teacher.exams.questions.destroy', [$exam->id, $question->id]) }}" method="POST" style="display:inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xoá?')">@lang('site.delete')</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 