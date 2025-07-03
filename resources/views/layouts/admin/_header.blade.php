<nav class="header-navbar navbar navbar-expand-lg align-items-center navbar-light navbar-shadow fixed-top">

    <div class="navbar-container d-flex content">

        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon"
                                                                                                   data-feather="menu"></i></a>
                </li>
            </ul>
        </div>

        <ul class="nav navbar-nav align-items-center ml-auto">

            {{--website--}}
            {{--<li class="nav-item">--}}
            {{--    <a class="nav-link" href="{{ route('/') }}" target="_blank">--}}
            {{--        <i class="fas fa-globe-europe font-medium-3"></i>--}}
            {{--    </a>--}}
            {{--</li>--}}

            {{--languages--}}
            <li class="nav-item dropdown dropdown-language">

                <a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">

                    <i class="flag-icon flag-icon-{{ $selectedLanguage->country_flag_code }}"></i>
                    <span class="selected-language">@lang('languages.' . app()->getLocale())</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">

                    @foreach(config('localization.supportedLocales') as $localeCode => $properties)

                        <a class="dropdown-item" hreflang="{{ $localeCode }}"
                           href="{{ route('admin.admin.switch_language', ['locale' => $localeCode]) }}"
                           data-language="{{ $localeCode }}">

                            <i class="flag-icon flag-icon-{{ $properties['country_flag_code'] }}"></i>

                            @lang('languages.' . $localeCode)
                        </a>

                    @endforeach

                </div>
            </li>

            {{--moon--}}
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon"
                                                                                         data-feather="moon"></i></a>
            </li>

            {{--notifications--}}
            <li class="nav-item dropdown dropdown-notification mr-25"><a class="nav-link" href="javascript:void(0);"
                                                                         data-toggle="dropdown"><i class="ficon"
                                                                                                   data-feather="bell"></i><span
                            class="badge badge-pill badge-danger badge-up">1</span></a>

                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">

                    <li class="dropdown-menu-header">
                        <div class="dropdown-header d-flex">
                            <h4 class="notification-title mb-0 mr-auto">@lang('site.notification')</h4>
                            <div class="badge badge-pill badge-light-primary">@lang('site.6_New')</div>
                        </div>
                    </li>

                    <li class="scrollable-container media-list">
                        <a class="d-flex" href="javascript:void(0)">
                            <div class="media d-flex align-items-start">
                                <div class="media-left">
                                    <div class="avatar"><img
                                                src="{{ asset('admin_assets/app-assets/images/portrait/small/avatar-s-15.jpg') }}"
                                                alt="avatar" width="32" height="32"></div>
                                </div>
                                <div class="media-body">
                                    <p class="media-heading"><span
                                                class="font-weight-bolder">@lang('site.new_registration')</span></p><small
                                            class="notification-text"> @lang('site.new_registration_des')</small>
                                </div>
                            </div>
                        </a>
                    </li>

                    <li class="dropdown-menu-footer">
                        <a class="btn btn-primary btn-block" href="javascript:void(0)">
                            @lang('site.mark_as_read')
                        </a>
                    </li>
                </ul>
            </li>

            {{--user--}}
            <li class="nav-item dropdown dropdown-user">
                <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="javascript:void(0);"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none">
                        <span class="user-name font-weight-bolder">{{ auth()->user()->full_name }}</span>
                        <span
                                class="user-status">{{ auth()->user()->hasRole('super_admin') ? __('users.super_admin') : __('users.admin') }}</span>
                    </div>
                    <span class="avatar"><img class="round" src="{{ auth()->user()->image_path }}" alt="avatar"
                                              height="40" width="40"><span class="avatar-status-online"></span></span>
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-user">

                    <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                        <i class="mr-50" data-feather="user"></i>
                        @lang('users.profile')
                    </a>

                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();"
                    >
                        <i class="mr-50" data-feather="power"></i>
                        @lang('site.logout')
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>

        </ul>
    </div>
</nav>
<!-- END: Header-->
