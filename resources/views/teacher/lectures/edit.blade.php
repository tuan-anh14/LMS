@php use App\Enums\GenderEnum;use App\Enums\LectureTypeEnum; @endphp
@extends('layouts.teacher.app')

@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('lectures.lectures')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('teacher.lectures.index') }}">@lang('lectures.lectures')</a></li>
                                <li class="breadcrumb-item active">@lang('site.edit')</li>
                            </ol>

                        </div><!-- end of breadcrumb -->
                    </div>
                </div><!-- end of row -->

            </div><!-- end of content header -->

        </div><!-- end of content header -->

        <div class="content-body">

            <div class="row">

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-body">

                            <form method="post" action="{{ route('teacher.lectures.update', $lecture->id) }}"
                                  class="ajax-form">
                                @csrf
                                @method('put')

                                {{--section_id--}}
                                <div class="form-group">
                                    <label>@lang('sections.section') <span class="text-danger">*</span></label>
                                    <select name="section_id" id="section-id" class="form-control select2" required>
                                        <option value="">@lang('site.choose') @lang('sections.section')</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}"
                                                    {{ $section->id == $lecture->section_id ? 'selected' : '' }}
                                                    data-lecture-types-url="{{ route('teacher.sections.lecture_types', $section->id) }}"
                                            >
                                                {{ $section->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--type--}}
                                <div class="form-group">
                                    <label>@lang('lectures.type') <span class="text-danger">*</span></label>
                                    <select name="type" id="lecture-type" class="form-control select2" required>
                                        <option value="">@lang('site.choose') @lang('lectures.type')</option>
                                        <option
                                            value="{{ LectureTypeEnum::EDUCATIONAL }}" {{ $lecture->type == LectureTypeEnum::EDUCATIONAL ? 'selected' : '' }}>@lang('lectures.educational')</option>

                                        @if ($lecture->section->project->hasTajweedLectures())
                                            <option
                                                value="{{ LectureTypeEnum::EDUCATIONAL_AND_TAJWEED }}" {{ $lecture->type == LectureTypeEnum::EDUCATIONAL_AND_TAJWEED ? 'selected' : '' }}>@lang('lectures.educational_and_tajweed')</option>
                                        @endif

                                        @if ($lecture->section->project->hasUpbringingLectures())
                                            <option
                                                value="{{ LectureTypeEnum::EDUCATIONAL_AND_UPBRINGING }}" {{ $lecture->type == LectureTypeEnum::EDUCATIONAL_AND_UPBRINGING ? 'selected' : '' }}>@lang('lectures.educational_and_upbringing')</option>
                                        @endif
                                    </select>
                                </div>

                                {{--date--}}
                                <div class="form-group">
                                    <label>@lang('lectures.date') <span class="text-danger">*</span></label>
                                    <input type="text" name="date" class="form-control date-picker" dir="rtl"
                                           value="{{ old('date', $lecture->date) }}" required>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i
                                            data-feather="edit"></i> @lang('site.update')</button>
                                </div>

                            </form><!-- end of form -->

                        </div><!-- end of card body -->

                    </div><!-- end of card -->

                </div><!-- end of col -->

            </div><!-- end of row -->

        </div><!-- end of content body -->

    </div><!-- end of content wrapper -->

@endsection
