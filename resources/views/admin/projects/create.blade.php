@php use App\Enums\GenderEnum; @endphp
@extends('layouts.admin.app')
@section('title')@lang('projects.projects')@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">

                <div class="row breadcrumbs-top">

                    <div class="col-12">

                        <h2 class="content-header-title float-left mb-0">@lang('projects.projects')</h2>

                        <div class="breadcrumb-wrapper">

                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}" wire:navigate>@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}" wire:navigate>@lang('projects.projects')</a></li>
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

                            <form method="post" action="{{ route('admin.projects.store') }}" class="ajax-form">
                                @csrf
                                @method('post')

                                {{--name--}}
                                <div class="form-group">
                                    <label>@lang('users.name') <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control" value="" required autofocus>
                                </div>

                                {{--book_id--}}
                                <div class="form-group">
                                    <label>@lang('books.book') <span class="text-danger">*</span></label>
                                    <select name="book_id" class="form-control select2" required>
                                        <option value="">@lang('site.choose') @lang('books.book')</option>
                                        @foreach ($books as $book)
                                            <option value="{{ $book->id }}">{{ $book->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--center_ids--}}
                                <div class="form-group">
                                    <label>@lang('centers.centers') <span class="text-danger">*</span></label>
                                    <select name="center_ids[]" class="form-control select2" multiple required>
                                        <option value="">@lang('site.choose') @lang('centers.centers')</option>
                                        @foreach ($centers as $center)
                                            <option value="{{ $center->id }}">{{ $center->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--has_tajweed_lectures--}}
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="has_tajweed_lectures" class="custom-control-input" id="has-tajweed-lectures" value="1">
                                        <label class="custom-control-label" for="has-tajweed-lectures">@lang('projects.has_tajweed_lectures')</label>
                                    </div>
                                </div>

                                {{--has_upbringing_lectures--}}
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="has_upbringing_lectures" class="custom-control-input" id="has-upbringing-lectures" value="1">
                                        <label class="custom-control-label" for="has-upbringing-lectures">@lang('projects.has_upbringing_lectures')</label>
                                    </div>
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
