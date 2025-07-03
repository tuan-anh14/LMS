@php use App\Enums\GenderEnum; @endphp
@extends('layouts.teacher.app')

@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('sections.sections')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teacher.sections.index') }}">@lang('sections.sections')</a></li>
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

                            <form method="post" action="{{ route('teacher.sections.update', $section->id) }}" class="ajax-form">
                                @csrf
                                @method('put')

                                {{--project_id--}}
                                <div class="form-group">
                                    <label>@lang('projects.project') <span class="text-danger">*</span></label>
                                    <select name="project_id" id="project-id" class="form-control select2" required>
                                        <option value="">@lang('site.choose') @lang('projects.project')</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}" {{ $project->id == $section->project_id ? 'selected' : '' }}>{{ $project->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--name--}}
                                <div class="form-group">
                                    <label>@lang('users.name') <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $section->name) }}" autofocus required>
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
