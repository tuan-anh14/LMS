<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">

    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" wire:navigate href="{{ route('examiner.home') }}">
                    <span class="brand-logo">
                    <img src="{{ asset('web_assets/images/logo.jpeg') }}" alt="">
                    </span>
                    <h2 class="brand-text">@lang('site.mirage')</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                       data-ticon="disc"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="shadow-bottom"></div>

    <div class="main-menu-content">

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">

            {{--            <li class=" nav-item"><a class="d-flex align-items-center" href="index.html"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Dashboards">Dashboards</span><span class="badge badge-light-warning badge-pill ml-auto mr-1">2</span></a>--}}
            {{--                <ul class="menu-content">--}}
            {{--                    <li><a class="d-flex align-items-center" href="dashboard-analytics.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Analytics">Analytics</span></a></li>--}}
            {{--                    <li><a class="d-flex align-items-center" href="dashboard-ecommerce.html"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="eCommerce">eCommerce</span></a>--}}
            {{--                    </li>--}}
            {{--                </ul>--}}
            {{--            </li>--}}

            <li class="{{ request()->is('*home*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('examiner.home') }}" wire:navigate>
                    <i data-feather="mail"></i><span class="menu-title text-truncate">@lang('site.home')</span>
                </a>
            </li>

            {{--students--}}
            {{--@if (auth()->user()->hasPermission('read_students'))
                <li class="{{ request()->is('*students*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('examiner.students.index') }}" wire:navigate>
                        <i data-feather="user-check"></i><span
                            class="menu-title text-truncate">@lang('students.students')</span>
                    </a>
                </li>
            @endif--}}

            {{--student_exams--}}
            @if (auth()->user()->hasRole('examiner'))
                <li class="{{ request()->is('*student_exams*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('examiner.student_exams.index') }}"
                       wire:navigate>
                        <i data-feather="paperclip"></i><span
                            class="menu-title text-truncate">@lang('student_exams.student_exams')</span>
                    </a>
                </li>
            @endif

            {{--sample--}}
            {{--            @if (auth()->user()->hasPermission('read_students'))--}}
            {{--                <li class="{{ request()->is('*students*') ? 'active' : '' }} nav-item">--}}
            {{--                    <a class="d-flex align-items-center" href="">--}}
            {{--                        <i data-feather="users"></i><span class="menu-title text-truncate"></span>--}}
            {{--                    </a>--}}
            {{--                </li>--}}
            {{--            @endif--}}

            {{--profile--}}
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="user"></i><span
                        class="menu-title text-truncate">@lang('users.profile')</span></a>
                <ul class="menu-content">
                    <li class="{{ request()->is('*profile*') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('examiner.profile.edit') }}" wire:navigate>
                            <i data-feather="circle"></i><span
                                class="menu-item text-truncate">@lang('users.profile')</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('*password*') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('examiner.profile.password.edit') }}"
                           wire:navigate>
                            <i data-feather="circle"></i><span
                                class="menu-item text-truncate">@lang('users.change_password')</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
<!-- END: Main Menu-->
