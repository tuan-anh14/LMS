@extends('layouts.teacher.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('questions.new_question') - {{ $exam->name }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teacher.exams.index') }}">@lang('exams.exams')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teacher.exams.questions.index', $exam->id) }}">@lang('questions.questions')</a></li>
                                <li class="breadcrumb-item active">@lang('site.create')</li>
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
                            <form method="POST" action="{{ route('teacher.exams.questions.store', $exam->id) }}" class="ajax-form">
                                @csrf
                                <div class="form-group">
                                    <label>@lang('questions.content') <span class="text-danger">*</span></label>
                                    <textarea name="content" class="form-control" required></textarea>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> @lang('site.create')</button>
                                    <a href="{{ route('teacher.exams.questions.index', $exam->id) }}" class="btn btn-secondary">@lang('site.cancel')</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 