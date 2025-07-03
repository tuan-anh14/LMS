@extends('layouts.admin.app')
@section('title')@lang('site.home')@endsection

@section('content')

    <div>
        <h2>@lang('site.home')</h2>
    </div>

    <ul class="breadcrumb mt-2">
        <li class="breadcrumb-item">@lang('site.statistics')</li>
    </ul>

    <div class="row my-1">

        @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('admin'))

            {{--roles_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('roles.roles_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $roles }}</h3>
                            <a href="{{ route('admin.roles.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--admins_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('admins.admins_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $admins }}</h3>
                            <a href="{{ route('admin.admins.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--slides_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('slides.slides_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $slides }}</h3>
                            <a href="{{ route('admin.slides.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--courses_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('courses.courses_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $courses }}</h3>
                            <a href="{{ route('admin.courses.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--centers_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('centers.centers_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $centers }}</h3>
                            <a href="{{ route('admin.centers.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--books_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('books.books_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $books }}</h3>
                            <a href="{{ route('admin.books.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--projects_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('projects.projects_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $projects }}</h3>
                            <a href="{{ route('admin.projects.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--sections_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('sections.sections_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $sections }}</h3>
                            <a href="{{ route('admin.sections.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--teachers_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('teachers.teachers_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $teachers }}</h3>
                            <a href="{{ route('admin.teachers.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--examiners_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('examiners.examiners_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $examiners }}</h3>
                            <a href="{{ route('admin.examiners.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--students_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('students.students_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $students }}</h3>
                            <a href="{{ route('admin.students.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

            {{--exams_count--}}
            <div class="col-md-4">

                <div class="card">

                    <div class="card-body">
                        <p class="lead">@lang('exams.exams_count')</p>

                        <div class="d-flex justify-content-between">
                            <h3>{{ $exams }}</h3>
                            <a href="{{ route('admin.exams.index') }}" wire:navigate>@lang('site.see_all')</a>
                        </div>

                    </div>

                </div>

            </div><!-- end of col -->

        @endif

    </div>

@endsection
