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
                                    <img src="{{ Storage::url('uploads/' . setting('logo')) }}" class="loaded-image"
                                         alt=""
                                         style="display: {{ setting('logo') ? 'block' : 'none' }}; width: 100px; margin: 10px 0;">
                                </div>

                                {{--fav_icon--}}
                                <div class="form-group">
                                    <label>@lang('settings.fav_icon')</label>
                                    <input type="file" name="fav_icon" class="form-control load-image">
                                    <img src="{{ Storage::url('uploads/' . setting('fav_icon')) }}" class="loaded-image"
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

                                {{--quran_we_ascend--}}
                                <div class="form-group">
                                    <label>@lang('settings.quran_we_ascend')</label>
                                    <input type="number" name="quran_we_ascend" class="form-control"
                                           value="{{ setting('quran_we_ascend') }}">
                                </div>

                                {{--convoy--}}
                                <div class="form-group">
                                    <label>@lang('settings.convoy')</label>
                                    <input type="number" name="convoy" class="form-control"
                                           value="{{ setting('convoy') }}">
                                </div>

                                {{--pulpits_of_light--}}
                                <div class="form-group">
                                    <label>@lang('settings.pulpits_of_light')</label>
                                    <input type="number" name="pulpits_of_light" class="form-control"
                                           value="{{ setting('pulpits_of_light') }}">
                                </div>

                                {{--arabic_reading--}}
                                <div class="form-group">
                                    <label>@lang('settings.arabic_reading')</label>
                                    <input type="number" name="arabic_reading" class="form-control"
                                           value="{{ setting('arabic_reading') }}">
                                </div>

                                {{--holy_quran_teachers_cadres--}}
                                <div class="form-group">
                                    <label>@lang('settings.holy_quran_teachers_cadres')</label>
                                    <input type="number" name="holy_quran_teachers_cadres" class="form-control"
                                           value="{{ setting('holy_quran_teachers_cadres') }}">
                                </div>

                                {{--licensed--}}
                                <div class="form-group">
                                    <label>@lang('settings.licensed')</label>
                                    <input type="number" name="licensed" class="form-control"
                                           value="{{ setting('licensed') }}">
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
