@extends('layouts.admin.app')
@section('title')@lang('slides.slides')@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('slides.slides')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}" wire:navigate>@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.slides.index') }}" wire:navigate>@lang('slides.slides')</a></li>
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

                            <form method="post" action="{{ route('admin.slides.update', $slide->id) }}" class="ajax-form">
                                @csrf
                                @method('put')

                                {{--upper_title--}}
                                <div class="form-group">
                                    <label>@lang('slides.upper_title') <span class="text-danger">*</span></label>
                                    <input type="text" name="upper_title" class="form-control" value="{{ old('upper_title', $slide->upper_title) }}" required autofocus>
                                </div>

                                {{--title--}}
                                <div class="form-group">
                                    <label>@lang('slides.title') <span class="text-danger">*</span></label>
                                    <input type="text" name="title" class="form-control" value="{{ old('title', $slide->title) }}" required>
                                </div>

                                {{--link--}}
                                <div class="form-group">
                                    <label>@lang('slides.link') <span class="text-danger">*</span></label>
                                    <input type="url" name="link" class="form-control" value="{{ old('url', $slide->link) }}" required>
                                </div>

                                {{--image--}}
                                <div class="form-group">
                                    <label>@lang('slides.image') <span class="text-danger">*</span></label>
                                    <input type="file" name="image" class="form-control load-image">
                                    <img src="{{ $slide->image_path }}" class="loaded-image" alt="" style="display: block; width: 200px; margin: 10px 0;">
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary"><i data-feather="edit"></i> @lang('site.update')</button>
                                </div>

                            </form><!-- end of form -->

                        </div><!-- end of card body -->

                    </div><!-- end of card -->

                </div><!-- end of col -->

            </div><!-- end of row -->

        </div><!-- end of content body -->

    </div><!-- end of content wrapper -->

@endsection
