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
                        <li><a href="{{route('courses')}}">@lang('site.courses')</a></li>
                        <li class="active">{{$course->title}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->
    
@endsection

