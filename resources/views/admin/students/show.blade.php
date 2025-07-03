@php use App\Enums\GenderEnum; @endphp
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
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">@lang('students.students')</a></li>
                                <li class="breadcrumb-item active">@lang('site.show')</li>
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

                            <div class="btn-group d-flex" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary ajax-data active" data-url="{{ route('admin.students.details', $student->id) }}" style="border-bottom-left-radius: 0">@lang('students.details')</button>
                                <button type="button" class="btn btn-primary ajax-data" data-url="{{ route('admin.students.logs', $student->id) }}" style="border-bottom-left-radius: 0">@lang('logs.logs')</button>
                            </div>

                            <div id="ajax-data-wrapper" style="padding-top: 20px">

                                @include('admin.students._details')

                            </div>

                        </div><!-- end of card body -->

                    </div><!-- end of card -->

                </div><!-- end of col -->

            </div><!-- end of row -->

        </div><!-- end of content body -->

    </div><!-- end of content wrapper -->

@endsection
