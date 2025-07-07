@extends('layouts.teacher.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('exams.edit_exam')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teacher.exams.index') }}">@lang('exams.exams')</a></li>
                                <li class="breadcrumb-item active">@lang('site.edit')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('teacher.exams.update', $exam->id) }}" class="ajax-form">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>@lang('exams.name') <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ $exam->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('projects.project') <span class="text-danger">*</span></label>
                                    <select name="project_id" class="form-control select2" required>
                                        <option value="">@lang('site.choose') @lang('projects.project')</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" @if($exam->project_id == $project->id) selected @endif>{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i data-feather="save"></i> @lang('site.save')</button>
                                    <a href="{{ route('teacher.exams.index') }}" class="btn btn-secondary">@lang('site.cancel')</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 