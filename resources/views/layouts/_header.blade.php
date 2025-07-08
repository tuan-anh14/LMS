<!-- Start Header Top
============================================= -->
<div class="top-bar-area address-two-lines bg-dark text-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 address-info">
                <div class="info box">

                    <ul>
                        <li>
                            <span><i class="fas fa-map"></i> @lang('site.address')</span>{{ setting('address') }}
                        </li>

                        <li>
                            <span><i class="fas fa-envelope-open"></i> @lang('site.email')</span>{{ setting('email') }}
                        </li>

                        <li>
                            <span><i class="fas fa-phone"></i> @lang('site.phone')</span>{{ setting('mobile') }}
                        </li>

                    </ul>

                </div>
            </div>

            <div class="user-login text-end col-md-4 d-flex align-items-center justify-content-end">

                @if (!auth()->user())
                    <a href="{{route('login')}}">
                        <i class="fas fa-users"></i> @lang('site.students')
                    </a>
                    <a href="{{route('login')}}">
                        <i class="fas fa-user"></i> @lang('site.teachers')
                    </a>
                @elseif(auth()->user()->hasRole('super_admin'))
                    <a href="{{route('admin.home')}}">
                        <i class="fas fa-users"></i> @lang('site.dashboard')
                    </a>
                @elseif(auth()->user()->hasRole('student'))
                    <a href="{{route('student.home')}}">
                        <i class="fas fa-users"></i> @lang('site.dashboard')
                    </a>
                @elseif(auth()->user()->hasRole('teacher'))
                    <a href="{{route('teacher.home')}}">
                        <i class="fas fa-users"></i> @lang('site.dashboard')
                    </a>
                @endif

            </div>

            {{--@if (auth()->user() && auth()->user()->hasRole('super_admin') || user()->hasRole('admin'))
                <div class="user-login text-right col-md-4">
                    <a class="" href="{{ route('admin.home')}} ">
                        <i class="fas fa-user"></i> @lang('site.dashboard')
                    </a>
                </div>
            @endif--}}

        </div>
    </div>
</div>
<!-- End Header Top -->

<!-- Header
============================================= -->
<header id="home">

    <!-- Start Navigation -->
    <nav class="navbar navbar-default navbar-sticky bootsnav">

        <!-- Start Top Search -->
        <div class="container">
            <div class="row">
                <div class="top-search">
                    <div class="input-group">
                        <form action="#">
                            <input type="text" name="text" class="form-control" placeholder="Search">
                            <button type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Search -->

        <div class="container">

            <!-- Start Atribute Navigation -->
            <div class="attr-nav">
                <ul>
                    {{--<li class="search"><a href="#"><i class="fa fa-search"></i></a></li>--}}
                    
                    <!-- Language Switcher -->
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @php
                                $currentLocale = app()->getLocale();
                                $currentFlag = config('localization.supportedLocales')[$currentLocale]['country_flag_code'] ?? 'vn';
                            @endphp
                            <i class="flag-icon flag-icon-{{ $currentFlag }}"></i>
                            <span class="selected-language">@lang('languages.' . app()->getLocale())</span>
                            <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu">
                            @foreach(config('localization.supportedLocales') as $localeCode => $properties)
                                <li>
                                    <a href="{{ route('switch_language', ['locale' => $localeCode]) }}" 
                                       hreflang="{{ $localeCode }}" 
                                       data-language="{{ $localeCode }}">
                                        <i class="flag-icon flag-icon-{{ $properties['country_flag_code'] }}"></i>
                                        @lang('languages.' . $localeCode)
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li>
                        @if (!auth()->user())
                            <a style="color: white" class="btn btn-info btn-sm-lm" href="{{route('login')}}"
                               role="button">@lang('site.login')</a>
                        @elseif(auth()->user()->hasRole('super_admin'))
                            <a style="color: white" class="btn btn-info btn-sm-lm" href="{{route('admin.home')}}">
                                @lang('site.dashboard')
                            </a>
                        @elseif(auth()->user()->hasRole('student'))
                            <a style="color: white" class="btn btn-info btn-sm-lm" href="{{route('student.home')}}">
                                @lang('site.dashboard')
                            </a>
                        @elseif(auth()->user()->hasRole('teacher'))
                            <a style="color: white" class="btn btn-info btn-sm-lm" href="{{route('teacher.home')}}">
                                @lang('site.dashboard')
                            </a>
                        @endif
                    </li>
                </ul>
            </div>
            <!-- End Atribute Navigation -->

            <!-- Start Header Navigation -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                    <i class="fa fa-bars"></i>
                </button>

                <a class="navbar-brand" href="{{route('/')}}">
                    @if(app()->getLocale() == 'en')
                        <span style="font-size: 24px; font-weight: bold; color: #01b5dd;">
                            <i class="fas fa-graduation-cap"></i> LMS
                        </span>
                    @else
                        <span style="font-size: 24px; font-weight: bold; color: #01b5dd;">
                            <i class="fas fa-graduation-cap"></i> Hệ thống LMS
                        </span>
                    @endif
                </a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#">
                    <li>
                        <a href="{{route('about-us')}}">@lang('site.about_us')</a>
                    </li>
                    <li>
                        <a href="{{route('contact-us')}}">@lang('site.contact_us')</a>
                    </li>
                    <li>
                        <a href="{{route('courses')}}">@lang('site.courses')</a>
                    </li>
                    <li>
                        <a href="{{route('/')}}">@lang('site.home')</a>
                    </li>
                    <li class="hidden-md hidden-xl hidden-lg">
                        @if (!auth()->user())
                            <a href="{{route('login')}}">
                                <i class="fas fa-users"></i> @lang('site.students')
                            </a>
                            <a href="{{route('login')}}">
                                <i class="fas fa-user"></i> @lang('site.teachers')
                            </a>
                        @elseif(auth()->user()->hasRole('super_admin'))
                            <a href="{{route('admin.home')}}">
                                <i class="fas fa-users"></i> @lang('site.dashboard')
                            </a>
                        @elseif(auth()->user()->hasRole('student'))
                            <a href="{{route('student.home')}}">
                                <i class="fas fa-users"></i> @lang('site.dashboard')
                            </a>
                        @elseif(auth()->user()->hasRole('teacher'))
                            <a href="{{route('teacher.home')}}">
                                <i class="fas fa-users"></i> @lang('site.dashboard')
                            </a>
                        @endif
                    </li>


                </ul>

            </div><!-- /.navbar-collapse -->

        </div>

    </nav>
    <!-- End Navigation -->

</header>
<!-- End Header -->
