<!-- Start Header Top
============================================= -->
<div class="top-bar-area address-two-lines bg-dark text-light">
    <div class="container">
        <div class="row">
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

            <div class="user-login text-end col-lg-4">

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
                    <img src="{{ Storage::url('uploads/' . setting('logo')) }}" class="logo" alt="Logo" width="">
                </a>
            </div>
            <!-- End Header Navigation -->

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-menu">
                <ul class="nav navbar-nav navbar-right" data-in="#" data-out="#">
                    <li>
                        <a href="{{route('/')}}">الرئيسية</a>
                    </li>
                    <li>
                        <a href="{{route('courses')}}">الدورات</a>
                    </li>
                    <li>
                        <a href="{{route('contact-us')}}">تواصل معنا</a>
                    </li>
                    <li>
                        <a href="{{route('about-us')}}">من نحن</a>
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
