@php use App\Enums\GenderEnum;use App\Enums\ReadingTypeEnum; @endphp
@extends('layouts.admin.app')
@section('title')@lang('students.students')@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('students.students')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a>
                                </li>
                                <li class="breadcrumb-item"><a
                                        href="{{ route('admin.students.index') }}">@lang('students.students')</a></li>
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

                            <form method="post" action="{{ route('admin.students.update', $student->id) }}"
                                  class="ajax-form">
                                @csrf
                                @method('put')

                                {{--country_id--}}
                                <div class="form-group">
                                    <label>@lang('countries.country') <span class="text-danger">*</span></label>
                                    <select name="country_id" id="country-id" class="form-control select2" required>
                                        <option value="">@lang('site.choose') @lang('countries.country')</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}"
                                                    data-governorates-url="{{ route('admin.countries.governorates', $country->id) }}"
                                                {{ $country->id == $student->country_id ? 'selected' : ''}}
                                            >
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--governorate_id--}}
                                <div class="form-group">
                                    <label>@lang('governorates.governorate') <span class="text-danger">*</span></label>
                                    <select name="governorate_id" id="governorate-id" class="form-control select2"
                                            required>
                                        <option value="">@lang('site.choose') @lang('governorates.governorate')</option>
                                        @foreach ($governorates as $governorate)
                                            <option
                                                value="{{ $governorate->id }}" {{ $governorate->id == $student->governorate_id ? 'selected' : '' }}>{{ $governorate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">

                                    {{--first_name--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.name') <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" class="form-control"
                                                   value="{{ old('name', $student->first_name) }}" autofocus required>
                                        </div>
                                    </div>

                                    {{--second_name--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.second_name') <span class="text-danger">*</span></label>
                                            <input type="text" name="second_name" class="form-control"
                                                   value="{{ old('name', $student->second_name) }}" required>
                                        </div>
                                    </div>

                                    {{--nickname--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.nickname') <span class="text-danger">*</span></label>
                                            <input type="text" name="nickname" class="form-control"
                                                   value="{{ old('nickname', $student->nickname) }}" required>
                                        </div>
                                    </div>

                                    {{--registration_date--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.registration_date')</label>
                                            <input type="text" name="registration_date" class="form-control date-picker"
                                                   value="{{ old('registration_date', $student->registration_date) }}">
                                        </div>
                                    </div>

                                    {{--email--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.email') <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                   value="{{ old('email', $student->email) }}" required>
                                        </div>
                                    </div>

                                    {{--mobile--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.mobile') <span class="text-danger">*</span></label>
                                            <input type="number" name="mobile" class="form-control"
                                                   value="{{ old('mobile', $student->mobile) }}" required>
                                        </div>
                                    </div>

                                </div><!-- end of row -->


                                <div class="row">

                                    {{--gender--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.gender') <span class="text-danger">*</span></label>
                                            <select name="gender" class="form-control select2" required>
                                                <option value="">@lang('site.choose') @lang('users.gender')</option>
                                                @foreach ([GenderEnum::MALE, GenderEnum::FEMALE] as $gender)
                                                    <option
                                                        value="{{ $gender }}" {{ $gender == $student->gender ? 'selected' : '' }}>@lang('users.' . $gender)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{--dob--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.dob') <span class="text-danger">*</span></label>
                                            <input type="text" name="dob" class="form-control date-picker"
                                                   value="{{ old('dob', $student->dob) }}" required>
                                        </div>
                                    </div>

                                </div><!-- end of row -->

                                {{--image--}}
                                <div class="form-group">
                                    <label>@lang('users.image') <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control load-image">
                                    <img src="{{ $student->image_path }}" class="loaded-image" alt=""
                                         style="display: block; width: 100px; margin: 10px 0;">
                                </div>

                                {{--address--}}
                                <div class="form-group">
                                    <label>@lang('users.address') <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control"
                                           value="{{ old('address', $student->address) }}" required>
                                </div>

                                {{--reading_type--}}
                                <div class="form-group">
                                    <label>@lang('users.reading_type') <span class="text-danger">*</span></label>
                                    <select name="reading_type" class="form-control select2" required>
                                        <option value="">@lang('site.choose') @lang('users.reading_type')</option>
                                        @foreach (ReadingTypeEnum::getConstants() as $readingType)
                                            <option
                                                value="{{ $readingType }}" {{ $readingType == $student->reading_type ? 'selected' : '' }}>@lang('users.' . $readingType)</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--student_center_id--}}
                                <div class="form-group">
                                    <label>@lang('centers.center') <span class="text-danger">*</span></label>
                                    <select name="student_center_id" id="center-id" class="form-control select2"
                                            required>
                                        <option value="">@lang('site.choose') @lang('centers.center')</option>
                                        @foreach ($centers as $center)
                                            <option value="{{ $center->id }}"
                                                    {{ $center->id == $student->student_center_id ? 'selected' : '' }}
                                                    data-projects-url="{{ route('admin.centers.projects', $center->id) }}"
                                            >
                                                {{ $center->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--project_id--}}
                                <div class="form-group">
                                    <label>@lang('projects.project') <span class="text-danger">*</span></label>
                                    <select name="student_project_id" id="project-id" class="form-control select2"
                                            required>
                                        <option value="">@lang('site.choose') @lang('projects.project')</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}"
                                                    {{ $project->id == $student->student_project_id ? 'selected' : '' }}
                                                    data-sections-url="{{ route('admin.projects.sections', $project->id) }}"
                                            >
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--section_id--}}
                                <div class="form-group">
                                    <label>@lang('sections.section') <span class="text-danger">*</span></label>
                                    <select name="student_section_id" id="section-id" class="form-control select2"
                                            required>
                                        <option value="">@lang('site.choose') @lang('sections.section')</option>
                                        @foreach ($sections as $section)
                                            <option
                                                value="{{ $section->id }}" {{ $section->id == $student->student_section_id ? 'selected' : '' }}>{{ $section->name }}</option>
                                        @endforeach
                                    </select>
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
