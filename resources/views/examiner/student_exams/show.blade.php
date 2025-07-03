@php use App\Enums\StudentExamStatusEnum; @endphp
@extends('layouts.examiner.app')

@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('student_exams.student_exams')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('examiner.home') }}">@lang('site.home')</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('examiner.student_exams.index') }}">@lang('student_exams.student_exams')</a>
                                </li>
                                <li class="breadcrumb-item active">@lang('site.show')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end of content header -->

        <div class="content-body">

            <div class="row">

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-7">

                                    <table class="table table-striped">

                                        <tr>
                                            <th style="width: 25%;">@lang('students.student')</th>
                                            <th style="display: flex">
                                                <div class="mr-2">
                                                    {{--{{ $studentExam->student->name }}--}}
                                                    {{ $studentExam->student->full_name }}
                                                </div>
                                                {{--<a href="{{ route('examiner.students.show', $studentExam->student_id) }}">@lang('site.show')</a>--}}
                                            </th>
                                        </tr>

                                        <tr>
                                            <th style="width: 25%;">@lang('users.mobile')</th>
                                            <th style="display: flex">
                                                <div class="mr-2">
                                                    {{ $studentExam->student->mobile }}
                                                </div>
                                                {{--<a href="{{ route('examiner.students.show', $studentExam->student_id) }}">@lang('site.show')</a>--}}
                                            </th>
                                        </tr>

                                        <tr>
                                            <th>@lang('teachers.teacher')</th>
                                            <th>{{ $studentExam->teacher->name }}</th>
                                        </tr>

                                        <tr>
                                            <th>@lang('teachers.examiner')</th>
                                            <th>{{ $studentExam->examiner->name }}</th>
                                        </tr>

                                        <tr>
                                            <th>@lang('exams.exam')</th>
                                            <th>{{ $studentExam->exam->name }}</th>
                                        </tr>

                                        <tr>
                                            <th>@lang('centers.center')</th>
                                            <th>{{ $studentExam->center->name }}</th>
                                        </tr>

                                        <tr>
                                            <th>@lang('sections.section')</th>
                                            <th>{{ $studentExam->section->name }}</th>
                                        </tr>

                                        <tr>
                                            <th>@lang('projects.project')</th>
                                            <th>{{ $studentExam->project->name }}</th>
                                        </tr>

                                        <tr>
                                            <th>@lang('student_exams.status')</th>
                                            <th>@lang('student_exams.' . $studentExam->status)</th>
                                        </tr>

                                        <tr>
                                            <th>@lang('student_exams.date_time')</th>
                                            <th>{{ $studentExam->date_time?->translatedFormat('Y-m-d / h:i a') }}</th>
                                        </tr>

                                        <tr>
                                            <th>@lang('student_exams.assessment')</th>
                                            <th>
                                                @if ($studentExam->assessment)
                                                    @lang('student_exams.' . $studentExam->assessment)
                                                @endif
                                            </th>
                                        </tr>

                                        <tr>
                                            <th>@lang('student_exams.notes')</th>
                                            <th>
                                                @if ($studentExam->notes)
                                                    {{ $studentExam->notes }}
                                                @endif
                                            </th>
                                        </tr>

                                    </table>

                                </div>

                                <div class="col-md-5">

                                    <table class="table mb-2 table-striped">

                                        <tr>
                                            <th>@lang('student_exams.status')</th>
                                            <th>@lang('site.created_at')</th>
                                        </tr>

                                        @foreach ($studentExam->statuses as $status)
                                            <tr>
                                                <td>@lang('student_exams.' . $status->status)</td>
                                                <td>{{ $status->created_at->translatedFormat('Y-m-d / h:i a') }}</td>
                                            </tr>
                                        @endforeach

                                    </table>

                                    @if (auth()->user()->hasRole('examiner') && $studentExam->examiner_id == auth()->user()->id)

                                        @if ($studentExam->status == StudentExamStatusEnum::ASSIGNED_TO_EXAMINER)

                                            <a href=""
                                               class="btn btn-primary btn-block ajax-modal"
                                               data-url="{{ route('examiner.student_exams.edit_date_time', $studentExam->id) }}"
                                               data-modal-title="@lang('student_exams.set_date_time')"
                                            >
                                                <i data-feather="clock"></i>
                                                @lang('student_exams.set_date_time')
                                            </a>

                                        @elseif($studentExam->status == StudentExamStatusEnum::DATE_TIME_SET)

                                            <a href=""
                                               class="btn btn-primary btn-block ajax-modal"
                                               data-url="{{ route('examiner.student_exams.edit_date_time', $studentExam->id) }}"
                                               data-modal-title="@lang('student_exams.set_date_time')"
                                            >
                                                <i data-feather="clock"></i>
                                                @lang('student_exams.set_date_time')
                                            </a>

                                            <a href=""
                                               class="btn btn-primary btn-block ajax-modal"
                                               data-url="{{ route('examiner.student_exams.edit_assessment', $studentExam->id) }}"
                                               data-modal-title="@lang('student_exams.add_assessment')"
                                            >
                                                <i data-feather="check-circle"></i>
                                                @lang('student_exams.add_assessment')
                                            </a>

                                        @endif

                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div><!-- end of content body -->

    </div><!-- end of content wrapper -->

@endsection
