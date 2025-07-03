@php use App\Enums\GenderEnum; @endphp
@extends('layouts.admin.app')
@section('title')@lang('examiners.examiners')@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('examiners.examiners')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}"
                                                               wire:navigate>@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.examiners.index') }}"
                                                               wire:navigate>@lang('examiners.examiners')</a></li>
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

                            <form method="post" action="{{ route('admin.examiners.update', $examiner->id) }}"
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
                                                {{ $country->id == $examiner->country_id ? 'selected' : ''}}
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
                                                value="{{ $governorate->id }}" {{ $governorate->id == $examiner->governorate_id ? 'selected' : '' }}>{{ $governorate->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="row">

                                    {{--first_name--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.first_name') <span class="text-danger">*</span></label>
                                            <input type="text" name="first_name" class="form-control"
                                                   value="{{ old('first_name', $examiner->first_name) }}" autofocus
                                                   required>
                                        </div>
                                    </div>

                                    {{--second_name--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.second_name') <span class="text-danger">*</span></label>
                                            <input type="text" name="second_name" class="form-control"
                                                   value="{{ old('second_name', $examiner->second_name) }}" autofocus
                                                   required>
                                        </div>
                                    </div>

                                    {{--nickname--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.nickname') <span class="text-danger">*</span></label>
                                            <input type="text" name="nickname" class="form-control"
                                                   value="{{ old('nickname', $examiner->nickname) }}" required>
                                        </div>
                                    </div>

                                    {{--email--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.email') <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control"
                                                   value="{{ old('email', $examiner->email) }}" required>
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
                                                        value="{{ $degree->id }}" {{ $degree->id == $examiner->degree_id ? 'selected' : '' }}>{{ $degree->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{--mobile--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.mobile') <span class="text-danger">*</span></label>
                                            <input type="number" name="mobile" class="form-control"
                                                   value="{{ old('mobile', $examiner->mobile) }}" required>
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
                                                        value="{{ $gender }}" {{ $gender == $examiner->gender ? 'selected' : '' }}>@lang('users.' . $gender)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{--dob--}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('users.dob') <span class="text-danger">*</span></label>
                                            <input type="text" name="dob" class="form-control date-picker"
                                                   value="{{ old('dob', $examiner->dob) }}" required>
                                        </div>
                                    </div>

                                </div><!-- end of row -->

                                {{--address--}}
                                <div class="form-group">
                                    <label>@lang('users.address') <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control"
                                           value="{{ old('address', $examiner->address) }}" required>
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
