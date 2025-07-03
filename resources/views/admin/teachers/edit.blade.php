@php use App\Enums\GenderEnum;use App\Enums\UserTypeEnum; @endphp
@extends('layouts.admin.app')
@section('title')@lang('teachers.teachers')@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('teachers.teachers')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"
                                                               wire:navigate>@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.teachers.index') }}"
                                                               wire:navigate>@lang('teachers.teachers')</a></li>
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

                            <form method="post" action="{{ route('admin.teachers.update', $teacher->id) }}"
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
                                                    {{ $country->id == $teacher->country_id ? 'selected' : ''}}
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
                                                    value="{{ $governorate->id }}" {{ $governorate->id == $teacher->governorate_id ? 'selected' : '' }}>{{ $governorate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">

                                    {{--first_name--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.first_name') <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" class="form-control"
                                                   value="{{ old('first_name', $teacher->first_name) }}" autofocus
                                                   required>
                                        </div>
                                    </div>

                                    {{--second_name--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.second_name') <span class="text-danger">*</span></label>
                                            <input type="text" name="second_name" class="form-control"
                                                   value="{{ old('second_name', $teacher->second_name) }}" autofocus
                                                   required>
                                        </div>
                                    </div>

                                    {{--nickname--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.nickname') <span class="text-danger">*</span></label>
                                            <input type="text" name="nickname" class="form-control"
                                                   value="{{ old('nickname', $teacher->nickname) }}" required>
                                        </div>
                                    </div>

                                    {{--email--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.email') <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                   value="{{ old('email', $teacher->email) }}" required>
                                        </div>
                                    </div>

                                </div><!-- end of row -->


                                <div class="row">

                                    {{--degree_id--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('degrees.degree') <span class="text-danger">*</span></label>
                                            <select name="degree_id" class="form-control select2" required>
                                                <option value="">@lang('site.choose') @lang('degrees.degree')</option>
                                                @foreach ($degrees as $degree)
                                                    <option
                                                            value="{{ $degree->id }}" {{ $degree->id == $teacher->degree_id ? 'selected' : '' }}>{{ $degree->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{--mobile--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.mobile') <span class="text-danger">*</span></label>
                                            <input type="number" name="mobile" class="form-control"
                                                   value="{{ old('mobile', $teacher->mobile) }}" required>
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
                                                            value="{{ $gender }}" {{ $gender == $teacher->gender ? 'selected' : '' }}>@lang('users.' . $gender)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{--dob--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.dob') <span class="text-danger">*</span></label>
                                            <input type="text" name="dob" class="form-control date-picker"
                                                   value="{{ old('dob', $teacher->dob) }}" required>
                                        </div>
                                    </div>

                                </div><!-- end of row -->

                                {{--address--}}
                                <div class="form-group">
                                    <label>@lang('users.address') <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control"
                                           value="{{ old('address', $teacher->address) }}" required>
                                </div>

                                <div class="d-flex ">
                                    <h4 class="mr-2">@lang('centers.centers')</h4>
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="centers">
                                </div>

                                @foreach ($centers as $index => $center)

                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox" style="margin-top: 10px;">
                                                    <input type="checkbox" name="centers[{{ $index }}][center]"
                                                           class="custom-control-input teacher-center"
                                                           id="center-{{ $center->id }}"
                                                           value="{{ $center->id }}"
                                                            {{ $teacher->isTeacherInCenterId($center->id) ? 'checked' : '' }}
                                                    >
                                                    <label class="custom-control-label"
                                                           for="center-{{ $center->id }}">{{ $center->name }}</label>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <select name="centers[{{ $index }}][section_ids][]"
                                                        class="form-control teacher-sections select2"
                                                        {{ $teacher->isTeacherInCenterId($center->id) == false ? 'disabled' : ''  }}
                                                        {{ $teacher->isTeacherInCenterId($center->id) == true ? 'required' : ''  }}
                                                        multiple
                                                >
                                                    <option
                                                            value="">@lang('site.choose') @lang('sections.sections')</option>
                                                    @foreach ($center->sections as $section)
                                                        <option value="{{ $section->id }}"
                                                                {{ $teacher->isTeacherForSectionIdInCenterId($section->id, $center->id) ? 'selected' : '' }}
                                                        >
                                                            {{ $section->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                    </div><!-- end of row -->

                                    <hr style="margin-top: 5px;">

                                @endforeach


                                <div class="custom-control custom-checkbox form-group">
                                    <input type="checkbox" class="custom-control-input" id="is-center-manager"
                                           value="1" {{ $teacher->isCenterManager() ? 'checked' : '' }}>
                                    <label class="custom-control-label"
                                           for="is-center-manager">@lang('teachers.is_center_manager')</label>
                                </div>

                                {{--center_ids--}}
                                <div class="form-group">
                                    <label>@lang('centers.centers') <span class="text-danger">*</span></label>
                                    <select name="center_ids_as_manager[]" id="center-ids-as-manager"
                                            class="form-control select2"
                                            {{ $teacher->isCenterManager() == false ? 'disabled' : '' }} multiple>
                                        <option value="">@lang('site.choose') @lang('centers.centers')</option>
                                        @foreach ($centers as $center)
                                            <option
                                                    value="{{ $center->id }}" {{ $teacher->isCenterManagerForCenterId($center->id) ? 'selected' : '' }}>{{ $center->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--is_examiner--}}
                                <div class="custom-control custom-checkbox form-group">
                                    <input type="checkbox" name="is_examiner" class="custom-control-input"
                                           id="is-examiner" value="1" {{ $teacher->hasRole(UserTypeEnum::EXAMINER) ? 'checked' : '' }}>
                                    <label class="custom-control-label"
                                           for="is-examiner">@lang('teachers.is_examiner')</label>
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
