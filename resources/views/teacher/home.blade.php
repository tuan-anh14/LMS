@extends('layouts.teacher.app')

@section('content')

    <div>
        <h2>@lang('site.home')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item">@lang('site.home')</li>
    </ul>

    <div class="row my-1">

        @if (auth()->user()->isCenterManagerForCenterId(session('selected_center')['id']))

            {{--sections_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('centers.sections_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $center->sections_count }}</h3>
                            <a href="{{ route('teacher.sections.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--teachers_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('centers.teachers_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $center->teachers_count }}</h3>
                            <a href="{{ route('teacher.teachers.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--students_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('centers.students_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $center->students_count }}</h3>
                            <a href="{{ route('teacher.students.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--projects_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('centers.projects_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $center->projects_count }}</h3>
                            <a href="{{ route('teacher.projects.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--lectures_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('centers.lectures_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $center->lectures_count }}</h3>
                            <a href="{{ route('teacher.lectures.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--exams_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('centers.exams_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $center->exams_count }}</h3>
                            <a href="{{ route('teacher.exams.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

        @endif

        @if (auth()->user()->isExaminer())

            {{--assigned_to_examiner_exams_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('exams.assigned_student_exams_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $assignedStudentExamsCount }}</h3>
                            <a href="{{ route('teacher.student_exams.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

        @endif

    </div>

@endsection