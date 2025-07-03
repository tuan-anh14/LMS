@extends('layouts.admin.app')
@section('title')@lang('courses.courses')@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('courses.courses')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}" wire:navigate>@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.courses.index') }}" wire:navigate>@lang('courses.courses')</a></li>
                                <li class="breadcrumb-item active">@lang('site.create')</li>
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

                            <form method="post" action="{{ route('admin.courses.store') }}" class="ajax-form">
                                @csrf
                                @method('post')

                                {{--title--}}
                                <div class="form-group">
                                    <label>@lang('courses.title') <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                </div>

                                {{--short_description--}}
                                <div class="form-group">
                                    <label>@lang('courses.short_description') <span class="text-danger">*</span></label>
                                    <textarea name="short_description" class="form-control">{{ old('short_description') }}</textarea>
                                </div>

                                {{--description--}}
                                <div class="form-group">
                                    <label>@lang('courses.description') <span class="text-danger">*</span></label>
                                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                </div>

                                {{--image--}}
                                <div class="form-group">
                                    <label>@lang('courses.image') <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control load-image">
                                    <img src="" class="loaded-image" alt="" style="display: none; width: 200px; margin: 10px 0;">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> @lang('site.create')</button>
                                </div>

                            </form><!-- end of form -->

                        </div><!-- end  card body-->

                    </div><!-- end of card -->

                </div><!-- end of row -->

            </div><!-- end of col -->

        </div><!-- end of content body -->

    </div><!-- end of content wrapper -->

@endsection
