@php use App\Enums\StudentExamStatusEnum; @endphp
@extends('layouts.student.app')

@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('student_exams.student_exams')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teacher.student_exams.index') }}">@lang('student_exams.student_exams')</a></li>
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
                                            <th>{{ $studentExam->student->name }}</th>
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

                                        @php
                                            $totalPossibleScore = $studentExam->exam->questions->sum('points') ?? $studentExam->exam->questions->count();
                                            $totalScore = $studentExam->answers->whereNotNull('score')->sum('score');
                                            $percentage = $totalPossibleScore > 0 ? ($totalScore / $totalPossibleScore * 100) : 0;
                                            $assessment = $studentExam->assessment;
                                            // Chỉ đánh giá khi đã làm bài (có câu trả lời)
                                            $hasAnswers = $studentExam->answers->whereNotNull('answer_text')->count() > 0;
                                            if (!$assessment && $hasAnswers) {
                                                if ($percentage >= 90) $assessment = 'superiority';
                                                elseif ($percentage >= 80) $assessment = 'excellent';
                                                elseif ($percentage >= 70) $assessment = 'very_good';
                                                elseif ($percentage >= 60) $assessment = 'good';
                                                else $assessment = 'repeat';
                                            }
                                        @endphp
                                        <tr>
                                            <th>Đánh giá</th>
                                            <th>
                                                @if($assessment)
                                                    <span class="badge badge-lg badge-
                                                        @if($assessment === 'excellent') success
                                                        @elseif(in_array($assessment, ['very_good', 'good'])) primary
                                                        @elseif($assessment === 'average') warning
                                                        @else danger @endif
                                                    " style="color: #6e6b7b; font-weight: 600;">
                                                        @switch($assessment)
                                                            @case('excellent') <i class="fas fa-star"></i> Xuất sắc @break
                                                            @case('very_good') <i class="fas fa-thumbs-up"></i> Rất tốt @break
                                                            @case('good') <i class="fas fa-check"></i> Tốt @break
                                                            @case('average') <i class="fas fa-equals"></i> Trung bình @break
                                                            @case('below_average') <i class="fas fa-arrow-down"></i> Dưới trung bình @break
                                                            @case('poor') <i class="fas fa-times"></i> Kém @break
                                                            @default {{ $assessment }}
                                                        @endswitch
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">Chưa có đánh giá</span>
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

                                    @php
                                        $now = \Carbon\Carbon::now();
                                        $expired = $studentExam->date_time && $now->gt($studentExam->date_time);
                                    @endphp

                                    @if ($expired)
                                        <div class="alert alert-danger">
                                            Đã quá thời hạn nộp bài kiểm tra!
                                        </div>
                                    @elseif ($studentExam->status !== 'submitted' && $studentExam->status !== \App\Enums\StudentExamStatusEnum::ASSIGNED_TO_EXAMINER)
                                        <a href="{{ route('student.student_exams.take', $studentExam) }}" class="btn btn-success btn-block">
                                            <i data-feather="edit"></i> Làm bài kiểm tra
                                        </a>
                                    @endif

                                    @if ($studentExam->status === 'submitted')
                                        <div class="alert alert-info">
                                            <i data-feather="check-circle"></i>
                                            Bạn đã nộp bài thành công!
                                        </div>
                                        
                                        @php
                                            $hasScores = $studentExam->answers()->whereNotNull('score')->exists();
                                        @endphp
                                        
                                        @if ($hasScores || $studentExam->assessment)
                                            <a href="{{ route('student.student_exams.results', $studentExam) }}" class="btn btn-primary btn-block">
                                                <i data-feather="file-text"></i> Xem kết quả bài kiểm tra
                                            </a>
                                        @else
                                            <div class="alert alert-warning">
                                                <i data-feather="clock"></i>
                                                Đang chờ giám khảo chấm điểm...
                                            </div>
                                        @endif
                                    @endif

                                    @if (auth()->user()->hasRole('examiner') && $studentExam->examiner_id == auth()->user()->id)

                                        @if ($studentExam->status == StudentExamStatusEnum::ASSIGNED_TO_EXAMINER)

                                            <a href=""
                                               class="btn btn-primary btn-block ajax-modal"
                                               data-url="{{ route('teacher.student_exams.edit_date_time', $studentExam->id) }}"
                                               data-modal-title="@lang('student_exams.set_date_time')"
                                            >
                                                <i data-feather="clock"></i>
                                                @lang('student_exams.set_date_time')
                                            </a>

                                        @elseif($studentExam->status == StudentExamStatusEnum::DATE_TIME_SET)

                                            <a href=""
                                               class="btn btn-primary btn-block ajax-modal"
                                               data-url="{{ route('teacher.student_exams.edit_assessment', $studentExam->id) }}"
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
