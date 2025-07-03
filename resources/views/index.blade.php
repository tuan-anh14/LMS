@extends('layouts.app')

@section('content')

    <!-- Start Banner
============================================= -->
    <div class="banner-area content-top-heading less-paragraph text-normal slide-mobile">
        <div id="bootcarousel" class="carousel slide animate_text carousel-fade" data-ride="carousel">

            <!-- Wrapper for slides -->
            <div class="carousel-inner text-light carousel-zoom">
                @foreach($slides as $slide)
                    <div class="item {{($slide->id == 1 ? 'active' : '')}}">
                        <div class="slider-thumb bg-fixed"
                             style="background-image: url({{ Storage::url('uploads/' . $slide->image) }});"></div>
                        {{--<div class="box-table shadow dark">
                            <div class="box-cell">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="content">
                                                <h3 data-animation="animated slideInLeft">{{$slide->upper_title}}</h3>
                                                <h1 data-animation="animated slideInUp">{{$slide->title}}</h1>
                                                <a data-animation="animated slideInUp"
                                                   class="btn btn-light border btn-md"
                                                   href="{{route('about-us')}}">@lang('site.about_us')</a>
                                                <a data-animation="animated slideInUp"
                                                   class="btn btn-theme effect btn-md"
                                                   href="{{$slide->link}}">@lang('site.read_more')</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>--}}
                    </div>
                @endforeach
            </div>
            <!-- End Wrapper for slides -->

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#bootcarousel" data-slide="prev">
                <i class="fa fa-angle-right"></i>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#bootcarousel" data-slide="next">
                <i class="fa fa-angle-left"></i>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>
    <!-- End Banner -->

    <!-- Start Popular Courses
    ============================================= -->
    <div class="popular-courses bg-gray circle carousel-shadow default-padding">
        <div class="container">
            <div class="row">
                <div class="site-heading text-center">
                    <div class="col-md-8 col-md-offset-2">
                        <h2>@lang('site.courses')</h2>
                        {{--<p>
                            @lang('site.courses_des')
                        </p>--}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="popular-courses-items popular-courses-carousel owl-carousel owl-theme">
                        @foreach($courses as $course)
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
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Popular Courses -->

    <!-- Start Why Chose Us
    ============================================= -->
    <div class="wcs-area bg-dark text-light">
        <div class="container-full">
            <div class="row">
                <div class="col-md-6 thumb bg-cover"
                     style="background-image: url({{'images/section-why-us.jpg'}});background-position: left;"></div>
                <div class="col-md-6 content">
                    <div class="site-heading text-left">
                        <h2>@lang('site.why_us_title')</h2>
                        <p>
                            @lang('site.why_us_des')
                        </p>
                    </div>

                    <!-- item -->
                    <div class="item">
                        <div class="icon">
                            <i class="flaticon-trending"></i>
                        </div>
                        <div class="info">
                            <h4>
                                <a href="javascript:;">@lang('site.best_courses')</a>
                            </h4>
                            <p>
                                @lang('site.best_courses_des')
                            </p>
                        </div>
                    </div>
                    <!-- item -->

                    <!-- item -->
                    <div class="item">
                        <div class="icon">
                            <i class="flaticon-books"></i>
                        </div>
                        <div class="info">
                            <h4>
                                <a href="javascript:;">@lang('site.best_books')</a>
                            </h4>
                            <p>
                                @lang('site.best_books_des')
                            </p>
                        </div>
                    </div>
                    <!-- item -->

                    <!-- item -->
                    <div class="item">
                        <div class="icon">
                            <i class="flaticon-professor"></i>
                        </div>
                        <div class="info">
                            <h4>
                                <a href="javascript:;">@lang('site.best_teachers')</a>
                            </h4>
                            <p>
                                @lang('site.best_teachers_des')
                            </p>
                        </div>
                    </div>
                    <!-- item -->

                    <!-- item -->
                    <div class="item">
                        <div class="icon">
                            <i class="flaticon-learning"></i>
                        </div>
                        <div class="info">
                            <h4>
                                <a href="javascript:;">@lang('site.interactive_lessons')</a>
                            </h4>
                            <p>
                                @lang('site.interactive_lessons_des')
                            </p>
                        </div>
                    </div>
                    <!-- item -->

                </div>
            </div>
        </div>
    </div>
    <!-- End Why Chose Us -->

    <!-- Start About
    ============================================= -->
    <div class="about-area default-padding">
        <div class="container-fluid">
            <div class="row">
                <div class="our-features">
                    <div class="col-md-3 col-sm-3">
                        <div class="item mariner">
                            <div class="icon">
                                <i class="flaticon-faculty-shield"></i>
                            </div>
                            <div class="info">
                                <h2>@lang('site.expert_faculty')</h2>
                                <p>@lang('site.expert_faculty_des')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="item java">
                            <div class="icon">
                                <i class="flaticon-book-2"></i>
                            </div>
                            <div class="info">
                                <h2>@lang('site.online_learning')</h2>
                                <p>@lang('site.online_learning_des')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="item malachite">
                            <div class="icon">
                                <i class="flaticon-education"></i>
                            </div>
                            <div class="info">
                                <h2>@lang('site.scholarship')</h2>
                                <p>@lang('site.scholarship_des')</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="item casablanca">
                            <div class="icon">
                                <i class="flaticon-interaction"></i>
                            </div>
                            <div class="info">
                                <h2>@lang('site.our_values')</h2>
                                <p>@lang('site.our_values_des')</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End About -->

    <div class="fun-factor-area default-padding bottom-less text-center bg-fixed shadow dark-hard"
         style="background-image: url({{'images/banner.jpg'}});">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6 item">
                    <div class="fun-fact">
                        <div class="icon">
                            <i class="flaticon-professor"></i>
                        </div>
                        <div class="info">
                            <span class="timer" data-to="{{setting('teachers_count')}}"
                                  data-speed="5000">{{setting('teachers_count')}}</span>
                            <span class="medium">@lang('site.teachers_count')</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 item">
                    <div class="fun-fact">
                        <div class="icon">
                            <i class="flaticon-learning"></i>
                        </div>
                        <div class="info">
                            <span class="timer" data-to="{{setting('students_count')}}"
                                  data-speed="5000">{{setting('students_count')}}</span>
                            <span class="medium">@lang('site.students_count')</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 item">
                    <div class="fun-fact">
                        <div class="icon">
                            <i class="flaticon-diploma"></i>
                        </div>
                        <div class="info">
                            <span class="timer" data-to="{{setting('quran_we_ascend')}}"
                                  data-speed="5000">{{setting('quran_we_ascend')}}</span>
                            <span class="medium">@lang('site.quran_we_ascend')</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 item">
                    <div class="fun-fact">
                        <div class="icon">
                            <i class="flaticon-education"></i>
                        </div>
                        <div class="info">
                            <span class="timer" data-to="{{setting('convoy')}}"
                                  data-speed="5000">{{setting('convoy')}}</span>
                            <span class="medium">@lang('site.convoy')</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Testimonials
    ============================================= -->
    <div class="testimonials-area carousel-shadow default-padding bg-dark text-light">
        <div class="container">
            <div class="row">
                <div class="site-heading text-center">
                    <div class="col-md-8 col-md-offset-2">
                        <h2>@lang('site.parent_reviews')</h2>
                        <p>
                            @lang('site.parent_reviews_des')
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="clients-review-carousel owl-carousel owl-theme">

                        <div class="item">
                            <div class="col-md-5 thumb">
                                <img src="{{asset('web_assets/images/testimonial_1.png')}}" alt="Thumb">
                            </div>
                            <div class="col-md-7 info">
                                <p>
                                    @lang('site.review1_comment')
                                </p>
                                <h4>@lang('site.review1')</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-5 thumb">
                                <img src="{{asset('web_assets/images/testimonial_1.png')}}" alt="Thumb">
                            </div>
                            <div class="col-md-7 info">
                                <p>
                                    @lang('site.review1_comment')
                                </p>
                                <h4>@lang('site.review1')</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-5 thumb">
                                <img src="{{asset('web_assets/images/testimonial_1.png')}}" alt="Thumb">
                            </div>
                            <div class="col-md-7 info">
                                <p>
                                    @lang('site.review1_comment')
                                </p>
                                <h4>@lang('site.review1')</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-5 thumb">
                                <img src="{{asset('web_assets/images/testimonial_1.png')}}" alt="Thumb">
                            </div>
                            <div class="col-md-7 info">
                                <p>
                                    @lang('site.review1_comment')
                                </p>
                                <h4>@lang('site.review1')</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-5 thumb">
                                <img src="{{asset('web_assets/images/testimonial_1.png')}}" alt="Thumb">
                            </div>
                            <div class="col-md-7 info">
                                <p>
                                    @lang('site.review1_comment')
                                </p>
                                <h4>@lang('site.review1')</h4>
                            </div>
                        </div>

                        {{--<div class="item">
                            <div class="col-md-5 thumb">
                                <img src="{{asset('web_assets/images/logo.jpeg')}}" alt="Thumb">
                            </div>
                            <div class="col-md-7 info">
                                <p>
                                    @lang('site.review2_comment')
                                </p>
                                <h4>@lang('site.review2')</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-5 thumb">
                                <img src="{{asset('web_assets/images/logo.jpeg')}}" alt="Thumb">
                            </div>
                            <div class="col-md-7 info">
                                <p>
                                    @lang('site.review3_comment')
                                </p>
                                <h4>@lang('site.review3')</h4>
                            </div>
                        </div>
                        <div class="item">
                            <div class="col-md-5 thumb">
                                <img src="{{asset('web_assets/images/logo.jpeg')}}" alt="Thumb">
                            </div>
                            <div class="col-md-7 info">
                                <p>
                                    @lang('site.review4_comment')
                                </p>
                                <h4>@lang('site.review4')</h4>
                            </div>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonials -->
@endsection

