@extends('layouts.app')

@section('content')
    <!-- Start Breadcrumb
    ============================================= -->
    <div class="breadcrumb-area shadow dark text-center bg-fixed text-light"
         style="background-image: url({{asset('images/banner.jpg')}});">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>@lang('site.contact_us')</h1>
                    <ul class="breadcrumb">
                        <li><a href="{{route('/')}}"><i class="fas fa-home"></i> @lang('site.home')</a></li>
                        <li class="active">@lang('site.contact_us')</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumb -->
    <div class="contact-info-area default-padding">
        <div class="container">
            <div class="row">
                <!-- Start Contact Info -->
                <div class="contact-info">
                    <div class="col-md-4 col-sm-4">
                        <div class="item">
                            <div class="icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <div class="info">
                                <h4>@lang('site.phone')</h4>
                                <span>{{setting('mobile')}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="item">
                            <div class="icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="info">
                                <h4>@lang('site.address')</h4>
                                <span>@lang('site.online_courses')</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="item">
                            <div class="icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info">
                                <h4>@lang('site.email')</h4>
                                <span>{{setting('email')}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Contact Info -->

                <div class="seperator col-md-12">
                    <span class="border"></span>
                </div>

                <!-- Start Maps & Contact Form -->
                <div class="maps-form" id="contact-sent">
                    <div class="col-md-6 maps">
                        <h3>@lang('site.free_contact')</h3>
                        <div class="google-maps">
                            <img src="{{asset('images/about-us.jpg')}}" alt="Thumb">
                        </div>
                    </div>
                    <div class="col-md-6 form">
                        <div class="heading">
                            <h3>@lang('site.contact_us')</h3>
                            <p>
                                @lang('site.contact_us_des')
                            </p>
                        </div>
                        <!-- Alert Message -->
                        @if(session('contact_success'))
                            <div class="alert alert-success" role="alert">@lang('site.send_successfully')</div>
                        @endif

                        <form action="{{ route('contact.post') }}#contact-sent" method="POST"
                        >
                            {{ csrf_field() }}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group">
                                        <input class="form-control" id="title" name="title"
                                               placeholder="@lang('site.title')"
                                               type="text">
                                        @if ($errors->has('title'))
                                            <span style="color: red" class="error">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group">
                                        <input class="form-control" id="email" name="email"
                                               placeholder="@lang('site.email')*"
                                               type="email">
                                        @if ($errors->has('email'))
                                            <span style="color: red" class="error">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group">
                                        <textarea class="form-control" id="message" name="message"
                                                  placeholder="@lang('site.message') *"></textarea>
                                        @if ($errors->has('message'))
                                            <span style="color: red"
                                                  class="error">{{ $errors->first('message') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <button type="submit">
                                        @lang('site.send') <i class="fa fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
                <!-- End Maps & Contact Form -->

            </div>
        </div>
    </div>
@endsection

