@extends('layouts.teacher.app')

@section('content')
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">@lang('exams.exams')</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                            <li class="breadcrumb-item active">@lang('exams.exams')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <div class="row mb-2">
            <div class="col-md-12">
                <a href="{{ route('teacher.exams.create') }}" class="btn btn-primary">
                    <i data-feather="plus"></i> @lang('exams.new_exam')
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
                                    <th>@lang('exams.name')</th>
                                    <th>@lang('projects.project')</th>
                                    <th>@lang('site.action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($exams as $exam)
                                <tr>
                                    <td>{{ $exam->name }}</td>
                                    <td>{{ $exam->project->name ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('teacher.exams.edit', $exam->id) }}" class="btn btn-sm btn-warning">@lang('site.edit')</a>
                                        <form action="{{ route('teacher.exams.destroy', $exam->id) }}" method="POST" style="display:inline-block" class="ajax-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete">@lang('site.delete')</button>
                                        </form>
                                        <a href="{{ route('teacher.exams.questions.index', $exam->id) }}" class="btn btn-sm btn-info">@lang('exams.manage_questions')</a>
                                        <a href="" class="btn btn-sm btn-success ajax-modal"
                                            data-url="{{ route('teacher.exams.assign_to_class', $exam->id) }}"
                                            data-modal-title="Giao bài cho cả lớp">
                                            Giao bài cho cả lớp
                                        </a>
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