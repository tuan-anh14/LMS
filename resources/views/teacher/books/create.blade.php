@extends('layouts.teacher.app')

@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('books.books')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">@lang('books.books')</a></li>
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

                            <form method="post" action="{{ route('teacher.books.store') }}" class="ajax-form">
                                @csrf
                                @method('post')

                                {{--project_id--}}
                                <div class="form-group">
                                    <label>@lang('projects.project') <span class="text-danger">*</span></label>
                                    <select name="project_id" class="form-control select2" required>
                                        <option value="">@lang('site.choose') @lang('projects.project')</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}">{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--name--}}
                                <div class="form-group">
                                    <label>@lang('books.name') <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="" autofocus required>
                                </div>

                                {{--number_of_pages--}}
                                <div class="form-group">
                                    <label>@lang('books.number_of_pages') <span class="text-danger">*</span></label>
                                    <input type="int" name="number_of_pages" class="form-control" value="{{ old('number_of_pages') }}" required>
                                </div>

                                {{--image--}}
                                <div class="form-group">
                                    <label>@lang('books.image') <span class="text-danger">*</span></label>
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
