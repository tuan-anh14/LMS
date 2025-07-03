<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">

    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" wire:navigate href="{{ route('teacher.home') }}">
                    <span class="brand-logo">
                    <img src="{{ asset('web_assets/images/logo.jpeg') }}" alt="">
                    </span>
                    <h2 class="brand-text">@lang('site.mirage')</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i>
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
                <a class="d-flex align-items-center" href="{{ route('teacher.home') }}" wire:navigate>
                    <i data-feather="mail"></i><span class="menu-title text-truncate">@lang('site.home')</span>
                </a>
            </li>

            {{--projects--}}
            @if (auth()->user()->hasPermission('read_projects', session('selected_center')['id']))
                <li class="{{ request()->is('*projects*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('teacher.projects.index') }}" wire:navigate>
                        <i data-feather="cpu"></i><span class="menu-title text-truncate">@lang('projects.projects')</span>
                    </a>
                </li>
            @endif

            {{--sections--}}
            @if (auth()->user()->hasPermission('read_sections', session('selected_center')['id']))
                <li class="{{ request()->is('*sections*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('teacher.sections.index') }}" wire:navigate>
                        <i data-feather="bar-chart"></i><span class="menu-title text-truncate">@lang('sections.sections')</span>
                    </a>
                </li>
            @endif

            {{--books--}}
            @if (auth()->user()->hasPermission('read_books', session('selected_center')['id']))
                <li class="{{ request()->is('*books*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('teacher.books.index') }}" wire:navigate>
                        <i data-feather="book"></i><span class="menu-title text-truncate">@lang('books.books')</span>
                    </a>
                </li>
            @endif

            {{--teachers--}}
            @if (auth()->user()->hasPermission('read_teachers', session('selected_center')['id']))
                <li class="{{ request()->is('*teachers*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('teacher.teachers.index') }}" wire:navigate>
                        <i data-feather="user-check"></i><span class="menu-title text-truncate">@lang('teachers.teachers')</span>
                    </a>
                </li>
            @endif

            {{--lectures--}}
            @if (auth()->user()->hasPermission('read_lectures', session('selected_center')['id']))
                <li class="{{ request()->is('*lectures*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('teacher.lectures.index') }}" wire:navigate>
                        <i data-feather="tag"></i><span class="menu-title text-truncate">@lang('lectures.lectures')</span>
                    </a>
                </li>
            @endif

            {{--students--}}
            @if (auth()->user()->hasPermission('read_students', session('selected_center')['id']))
                <li class="{{ request()->is('*students*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('teacher.students.index') }}" wire:navigate>
                        <i data-feather="user-check"></i><span class="menu-title text-truncate">@lang('students.students')</span>
                    </a>
                </li>
            @endif

            {{--student_exams--}}
            @if (auth()->user()->hasRole('examiner'))
                <li class="{{ request()->is('*student_exams*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('teacher.student_exams.index') }}" wire:navigate>
                        <i data-feather="paperclip"></i><span class="menu-title text-truncate">@lang('student_exams.student_exams')</span>
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
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="user"></i><span class="menu-title text-truncate">@lang('users.profile')</span></a>
                <ul class="menu-content">
                    <li class="{{ request()->is('*profile*') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('teacher.profile.edit') }}" wire:navigate>
                            <i data-feather="circle"></i><span class="menu-item text-truncate">@lang('users.profile')</span>
                        </a>
                    </li>

                    <li class="{{ request()->is('*password*') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('teacher.profile.password.edit') }}" wire:navigate>
                            <i data-feather="circle"></i><span class="menu-item text-truncate">@lang('users.change_password')</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
<!-- END: Main Menu-->
