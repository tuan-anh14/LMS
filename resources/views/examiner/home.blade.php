@extends('layouts.examiner.app')

@section('content')

    <div>
        <h2>@lang('site.home')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item">@lang('site.home')</li>
    </ul>

    <div class="row my-1">

        @if (auth()->user()->isExaminer())

            {{--assigned_to_examiner_exams_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('exams.assigned_student_exams_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $assignedStudentExamsCount }}</h3>
                            <a href="{{ route('examiner.student_exams.index') }}"
                               wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

        @endif

    </div>

@endsection
