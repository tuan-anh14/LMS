@extends('layouts.admin.app')
@section('title')@lang('settings.general')@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('settings.general')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a>
                                </li>
                                <li class="breadcrumb-item active">@lang('settings.settings')</li>
                                <li class="breadcrumb-item active">@lang('settings.general')</li>
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

                            <form method="post" action="{{ route('admin.settings.general_data') }}" class="ajax-form">
                                @csrf
                                @method('post')

                                {{--logo--}}
                                <div class="form-group">
                                    <label>@lang('settings.logo')</label>
                                    <input type="file" name="logo" class="form-control load-image">
                                    <img src="{{ asset('storage/uploads/logo.png') }}" class="loaded-image"
                                         alt=""
                                         style="display: {{ setting('logo') ? 'block' : 'none' }}; width: 100px; margin: 10px 0;">
                                </div>

                                {{--fav_icon--}}
                                <div class="form-group">
                                    <label>@lang('settings.fav_icon')</label>
                                    <input type="file" name="fav_icon" class="form-control load-image">
                                    <img src="{{ setting('fav_icon') ? Storage::url('uploads/' . setting('fav_icon')) : asset('images/default.jpg') }}" class="loaded-image"
                                         alt=""
                                         style="display: {{ setting('fav_icon') ? 'block' : 'none' }}; width: 50px; margin: 10px 0;">
                                </div>

                                {{--title--}}
                                <div class="form-group">
                                    <label>@lang('settings.title')</label>
                                    <input type="text" name="title" class="form-control" value="{{ setting('title') }}">
                                </div>

                                {{--description--}}
                                <div class="form-group">
                                    <label>@lang('settings.description')</label>
                                    <textarea name="description"
                                              class="form-control">{{ setting('description') }}</textarea>
                                </div>

                                {{--keywords--}}
                                <div class="form-group">
                                    <label>@lang('settings.keywords')</label>
                                    <input type="text" name="keywords" class="form-control"
                                           value="{{ setting('keywords') }}">
                                </div>

                                {{--mobile--}}
                                <div class="form-group">
                                    <label>@lang('settings.mobile') <span class="text-danger">*</span></label>
                                    <input type="tel" name="mobile" class="form-control" value="{{ setting('mobile') }}"
                                           required>
                                </div>

                                {{--email--}}
                                <div class="form-group">
                                    <label>@lang('users.email')</label>
                                    <input type="text" name="email" class="form-control" value="{{ setting('email') }}">
                                </div>

                                {{--address--}}
                                <div class="form-group">
                                    <label>@lang('settings.address') <span class="text-danger">*</span></label>
                                    <input type="text" name="address" class="form-control"
                                           value="{{ setting('address') }}" required>
                                </div>

                                {{--about_text--}}
                                <div class="form-group">
                                    <label>@lang('settings.about_text') <span class="text-danger">*</span></label>
                                    <textarea name="about_text"
                                              class="form-control">{{ setting('about_text') }}</textarea>
                                </div>

                                {{--teachers_count--}}
                                <div class="form-group">
                                    <label>@lang('settings.teachers_count')</label>
                                    <input type="number" name="teachers_count" class="form-control"
                                           value="{{ setting('teachers_count') }}">
                                </div>

                                {{--students_count--}}
                                <div class="form-group">
                                    <label>@lang('settings.students_count')</label>
                                    <input type="number" name="students_count" class="form-control"
                                           value="{{ setting('students_count') }}">
                                </div>

                                {{--courses_count--}}
                                <div class="form-group">
                                    <label>@lang('settings.courses_count')</label>
                                    <input type="number" name="courses_count" class="form-control"
                                           value="{{ setting('courses_count') }}">
                                </div>

                                {{--certificates_count--}}
                                <div class="form-group">
                                    <label>@lang('settings.certificates_count')</label>
                                    <input type="number" name="certificates_count" class="form-control"
                                           value="{{ setting('certificates_count') }}">
                                </div>

                                {{--success_rate--}}
                                <div class="form-group">
                                    <label>@lang('settings.success_rate') (%)</label>
                                    <input type="number" name="success_rate" class="form-control" min="0" max="100"
                                           value="{{ setting('success_rate') }}">
                                </div>

                                {{--years_experience--}}
                                <div class="form-group">
                                    <label>@lang('settings.years_experience')</label>
                                    <input type="number" name="years_experience" class="form-control"
                                           value="{{ setting('years_experience') }}">
                                </div>

                                {{--total_graduates--}}
                                <div class="form-group">
                                    <label>@lang('settings.total_graduates')</label>
                                    <input type="number" name="total_graduates" class="form-control"
                                           value="{{ setting('total_graduates') }}">
                                </div>

                                {{--active_students--}}
                                <div class="form-group">
                                    <label>@lang('settings.active_students')</label>
                                    <input type="number" name="active_students" class="form-control"
                                           value="{{ setting('active_students') }}">
                                </div>

                                {{--submit--}}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i
                                            class="fa fa-edit"></i> @lang('site.update')</button>
                                </div>

                            </form><!-- end of form -->

                        </div><!-- end of card body -->

                    </div><!-- end of card -->

                </div><!-- end of row -->

            </div><!-- end of col -->

        </div><!-- end of content body -->

    </div><!-- end of content wrapper -->

@endsection
