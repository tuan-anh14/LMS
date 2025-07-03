@extends('layouts.app')

@section('content')
    <!-- Start Breadcrumb
    ============================================= -->
    <div class="breadcrumb-area shadow dark text-center bg-fixed text-light"
         style="background-image: url({{asset('images/banner.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>@lang('site.courses')</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{route('/')}}"><i class="fas fa-home"></i> @lang('site.home')</a></li>
                        <li class="active">@lang('site.courses')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start Popular Courses
    ============================================= -->
    <div class="popular-courses default-padding bottom-less without-carousel">
        <div class="container">
            <div class="row">
                <div class="popular-courses-items">
                    @foreach($courses as $course)
                        <div class="col-md-4 col-sm-6 equal-height">
                            <div class="item">
                                <div class="thumb">
                                    <a href="javascript:;">
                                        <img src="{{Storage::url('uploads/' . $course->image)}}"
                                             alt="{{$course->title}}">
                                    </a>
                                </div>
                                <div class="info">
                                    <h4><a href="javascript:;">{{$course->title}}</a></h4>
                                    <p>
                                        {{$course->short_description}}
                                    </p>
                                    <div class="bottom-info">
                                        <a href="javascript:;">@lang('site.register_now')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <!-- End Popular Courses -->
@endsection

