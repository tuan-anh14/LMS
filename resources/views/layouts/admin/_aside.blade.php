<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">

    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" wire:navigate href="{{ route('admin.home') }}">
                    <span class="brand-logo">
                    <img src="{{ Storage::url('uploads/' . setting('logo')) }}" alt="">
                    </span>
                    <h2 class="brand-text">@lang('site.webseity')</h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
                <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                    <i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i>
                    <i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc"
                       data-ticon="disc"></i>
                </a></li>
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


            {{--home--}}
            <li class="{{ request()->is('*home*') ? 'active' : '' }} nav-item">
                <a class="d-flex align-items-center" href="{{ route('admin.home') }}" wire:navigate>
                    <i data-feather="clipboard"></i><span class="menu-title text-truncate">@lang('site.home')</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="d-flex align-items-center" href="{{ route('/') }}">
                    <i data-feather="home"></i><span class="menu-title text-truncate">@lang('site.web_home')</span>
                </a>
            </li>

            {{--roles--}}
            @if (auth()->user()->hasPermission('read_roles'))
                <li class="{{ request()->is('*roles*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.roles.index') }}" wire:navigate>
                        <i data-feather="lock"></i><span class="menu-title text-truncate">@lang('roles.roles')</span>
                    </a>
                </li>
            @endif

            {{--admins--}}
            @if (auth()->user()->hasPermission('read_admins'))
                <li class="{{ request()->is('*admins*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.admins.index') }}" wire:navigate>
                        <i data-feather="users"></i><span class="menu-title text-truncate">@lang('admins.admins')</span>
                    </a>
                </li>
            @endif

            {{--slides--}}
            @if (auth()->user()->hasPermission('read_slides'))
                <li class="{{ request()->is('*slides*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.slides.index') }}" wire:navigate>
                        <i data-feather="sliders"></i><span
                            class="menu-title text-truncate">@lang('slides.slides')</span>
                    </a>
                </li>
            @endif

            {{--courses--}}
            @if (auth()->user()->hasPermission('read_courses'))
                <li class="{{ request()->is('*courses*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.courses.index') }}" wire:navigate>
                        <i data-feather="video"></i><span
                            class="menu-title text-truncate">@lang('courses.courses')</span>
                    </a>
                </li>
            @endif

            {{--services--}}
            {{--@if (auth()->user()->hasPermission('read_services'))
                <li class="{{ request()->is('*services*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.services.index') }}" wire:navigate>
                        <i data-feather="server"></i><span
                            class="menu-title text-truncate">@lang('services.services')</span>
                    </a>
                </li>
            @endif--}}

            {{--centers--}}
            @if (auth()->user()->hasPermission('read_centers'))
                <li class="{{ request()->is('*centers*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.centers.index') }}" wire:navigate>
                        <i data-feather="align-center"></i><span
                            class="menu-title text-truncate">@lang('centers.centers')</span>
                    </a>
                </li>
            @endif

            {{--books--}}
            @if (auth()->user()->hasPermission('read_books'))
                <li class="{{ request()->is('*books*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.books.index') }}" wire:navigate>
                        <i data-feather="book"></i><span class="menu-title text-truncate">@lang('books.books')</span>
                    </a>
                </li>
            @endif

            {{--projects--}}
            @if (auth()->user()->hasPermission('read_projects'))
                <li class="{{ request()->is('*projects*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.projects.index') }}" wire:navigate>
                        <i data-feather="cpu"></i><span
                            class="menu-title text-truncate">@lang('projects.projects')</span>
                    </a>
                </li>
            @endif

            {{--sections--}}
            @if (auth()->user()->hasPermission('read_sections'))
                <li class="{{ request()->is('*sections*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.sections.index') }}" wire:navigate>
                        <i data-feather="bar-chart"></i><span
                            class="menu-title text-truncate">@lang('sections.sections')</span>
                    </a>
                </li>
            @endif

            {{--teachers--}}
            @if (auth()->user()->hasPermission('read_teachers'))
                <li class="{{ request()->is('*teachers*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.teachers.index') }}" wire:navigate>
                        <i data-feather="user-check"></i><span
                            class="menu-title text-truncate">@lang('teachers.teachers')</span>
                    </a>
                </li>
            @endif

            {{--teachers--}}
            @if (auth()->user()->hasPermission('read_examiners'))
                <li class="{{ request()->is('*examiners*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.examiners.index') }}" wire:navigate>
                        <i data-feather="users"></i><span
                            class="menu-title text-truncate">@lang('examiners.examiners')</span>
                    </a>
                </li>
            @endif

            {{--students--}}
            @if (auth()->user()->hasPermission('read_students'))
                <li class="{{ request()->is('*students*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.students.index') }}" wire:navigate>
                        <i data-feather="user"></i><span
                            class="menu-title text-truncate">@lang('students.students')</span>
                    </a>
                </li>
            @endif

            {{--exams--}}
            @if (auth()->user()->hasPermission('read_exams'))
                <li class="{{ request()->is('*exams*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.exams.index') }}" wire:navigate>
                        <i data-feather="paperclip"></i><span
                            class="menu-title text-truncate">@lang('exams.exams')</span>
                    </a>
                </li>
            @endif

            {{--inquiries--}}
            @if (auth()->user()->hasPermission('read_inquiries'))
                <li class="{{ request()->is('*inquiries*') ? 'active' : '' }} nav-item">
                    <a class="d-flex align-items-center" href="{{ route('admin.inquiries.index') }}" wire:navigate>
                        <i data-feather="video"></i><span
                            class="menu-title text-truncate">@lang('inquiries.inquiries')</span>
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
                        <a class="d-flex align-items-center" href="{{ route('admin.profile.edit') }}" wire:navigate>
                            <i data-feather="circle"></i><span
                                class="menu-item text-truncate">@lang('users.profile')</span>
                        </a>
                    </li>
                    <li class="{{ request()->is('*password*') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" href="{{ route('admin.profile.password.edit') }}"
                           wire:navigate>
                            <i data-feather="circle"></i><span
                                class="menu-item text-truncate">@lang('users.change_password')</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{--settings--}}
            <li class=" nav-item">
                <a class="d-flex align-items-center" href="#">
                    <i data-feather="settings"></i>
                    <span class="menu-title text-truncate" data-i18n="Dashboards">@lang('settings.settings')</span>
                </a>
                <ul class="menu-content">

                    @if (auth()->user()->hasPermission('read_settings'))
                        <li class="{{ request()->is('*settings/general_data*') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.settings.general_data') }}"
                               wire:navigate>
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate">@lang('settings.general')</span>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('read_countries'))
                        <li class="{{ request()->is('*countries*') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.countries.index') }}"
                               wire:navigate>
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate">@lang('countries.country')</span>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermission('read_governorates'))
                        <li class="{{ request()->is('*governorates*') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.governorates.index') }}"
                               wire:navigate>
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate">@lang('governorates.governorates')</span>
                            </a>
                        </li>
                    @endif

                    {{--@if (auth()->user()->hasPermission('read_governorates'))
                        <li class="{{ request()->is('*areas*') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.areas.index') }}" wire:navigate>
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate">@lang('areas.areas')</span>
                            </a>
                        </li>
                    @endif--}}

                    @if (auth()->user()->hasPermission('read_degrees'))
                        <li class="{{ request()->is('*degrees*') ? 'active' : '' }}">
                            <a class="d-flex align-items-center" href="{{ route('admin.degrees.index') }}"
                               wire:navigate>
                                <i data-feather="circle"></i>
                                <span class="menu-item text-truncate">@lang('degrees.degrees')</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

        </ul>
    </div>
</div>
<!-- END: Main Menu-->
