@extends('layouts.app')

@section('content')
    <!-- Start Breadcrumb
    ============================================= -->
    <div class="breadcrumb-area shadow dark text-center bg-fixed text-light"
         style="background-image: url({{asset('images/banner.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>@lang('site.about_us')</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{route('/')}}"><i class="fas fa-home"></i> @lang('site.home')</a></li>
                        <li class="active">@lang('site.about_us')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->
    <!-- Start About
============================================= -->
    <div class="about-area default-padding">
        <div class="container">
            <div class="row">
                <div class="about-info">
                    <div class="col-md-6 thumb">
                        <img src="{{asset('images/about-us.jpg')}}" alt="Thumb">
                    </div>
                    <div class="col-md-6 info">
                        <h5>@lang('site.about_us_subtitle')</h5>
                        <h2>@lang('site.about_us_title1')</h2>
                        <p>
                            @lang('site.about_us_description1')
                        </p>
                        <a href="https://wa.me/905518927802"
                           class="btn btn-dark border btn-md">@lang('site.register_now')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About -->

    <div class="video-area padding-xl text-center bg-fixed text-light shadow dark-hard"
         style="background-image: url({{asset('images/banner.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="video-heading">
                        <h2>@lang('site.videos_section_title')</h2>
                        <p>
                            @lang('site.videos_section_des')
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="video-info">
                    <div class="overlay-video">
                        <a class="popup-youtube video-play-button" href="https://www.youtube.com/watch?v=4kVt8Wq7_dQ">
                            <i class="fa fa-play"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

