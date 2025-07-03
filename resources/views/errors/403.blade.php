<!DOCTYPE html>
<html class="light-layout loaded" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
      data-textdirection="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" data-layout="bordered-layout">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
          content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
          content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="loading" content="@lang('site.loading')">
    <meta name="no-data-found" content="@lang('site.no_data_found')">
    <meta name="drop-images-text" content="@lang('site.drop_images')">
    <meta name="delete-text" content="@lang('site.delete')">

    <title>{{ setting('title') }}</title>

    <link rel="apple-touch-icon" href="{{ asset('admin_assets/app-assets/images/ico/favicon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin_assets/app-assets/images/ico/favicon.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin_assets/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin_assets/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin_assets/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/app-assets/vendors/js/noty/noty.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin_assets/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin_assets/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
    <!-- END: Vendor CSS-->

    {{--Vendor js--}}
    <script src="{{ asset('admin_assets/app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('admin_assets/app-assets/vendors/js/noty/noty.min.js') }}"></script>
    <script src="{{ asset('admin_assets/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
    <link rel="stylesheet"
          href="{{ asset('admin_assets/app-assets/vendors/css/easy-autocomplete/easy-autocomplete.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    {{--dropzone--}}
    <link rel="stylesheet" href="{{ asset('admin_assets/app-assets/vendors/js/dropzone/dropzone.min.css') }}">
    <script src="{{ asset('admin_assets/app-assets/vendors/js/dropzone/dropzone.min.js') }}"></script>

    {{--jstree--}}
    <link rel="stylesheet" href="{{ asset('admin_assets/app-assets/vendors/css/extensions/jstree.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin_assets/app-assets/css/plugins/extensions/ext-component-tree.css') }}">
    <script src="{{ asset('admin_assets/app-assets/vendors/js/extensions/jstree.min.js') }}"></script>

    {{--fontawesome--}}
    <link rel="stylesheet" href="{{ asset('admin_assets/app-assets/fonts/font-awesome/css/font-awesome.min.css') }}">

    <!-- BEGIN: Theme CSS-->
    @if (app()->getLocale() == 'ar')

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500&display=swap" rel="stylesheet">

        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/vendors/css/vendors-rtl.min.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css-rtl/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css-rtl/colors.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css-rtl/components.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/themes/dark-layout.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/themes/bordered-layout.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/themes/semi-dark-layout.css') }}">

        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css-rtl/custom-rtl.css') }}">


        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/plugins/forms/form-validation.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/pages/page-auth.css') }}">

        <style>

            *, html, body {
                font-family: 'Cairo', sans-serif;
            }

        </style>

    @else
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/vendors/css/vendors.min.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css/colors.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css/components.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css/themes/dark-layout.css') }}">

        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">

        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css/plugins/forms/form-wizard.css') }}">

    @endif

    <script src="{{ asset('admin_assets/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

    <link rel="stylesheet" href="{{ mix('admin_assets/app.min.css') }}">

    @stack('styles')
</head>

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click"
      data-menu="vertical-menu-modern" data-col="blank-page">
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-v1 px-2">

                <div class="auth-inner py-2">

                    <!-- Login v1 -->
                    <div class="card mb-0">
                        <div class="card-body">

                            {{--logo--}}
                            <div class="app-brand justify-content-center mb-6 text-center">
                                <a href="{{route('/')}}" class="app-brand-link">
                                    <span class="app-brand-logo demo">

                                        <img src="{{asset('images/login_logo.jpg')}}" alt="" width="150">

                                    </span>
                                    {{--<span class="app-brand-text demo text-heading fw-bold">معراج للتعليم والتنمية</span>--}}
                                </a>
                            </div>

                            <div class="text-center">
                                <img src="{{ asset('admin_assets/app-assets/images/logo_md.png') }}" alt="">
                            </div>

                            <h3 class="text-center mb-2">@lang('site.no_permission')</h3>

                            @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super_admin'))

                                <div class="text-center">
                                    <a href="{{ route('admin.home') }}" class="btn btn-primary">@lang('site.go_to_dashboard')</a>
                                </div>

                            @elseif(auth()->user()->hasRole('teacher'))

                                <div class="text-center">
                                    <a href="{{ route('teacher.home') }}" class="btn btn-primary">@lang('site.go_to_dashboard')</a>
                                </div>

                            @elseif(auth()->user()->hasRole('examiner'))

                                <div class="text-center">
                                    <a href="{{ route('examiner.home') }}" class="btn btn-primary">@lang('site.go_to_dashboard')</a>
                                </div>

                            @endif

                        </div>
                    </div>
                    <!-- /Login v1 -->
                </div>
            </div>

        </div>
    </div>
</div>
<!-- END: Content-->

<!-- BEGIN: Vendor JS-->
<script src="{{ asset('admin_assets/app-assets/vendors/js/vendors.min.js') }}"></script>

<!-- BEGIN: Theme JS-->
<script src="{{ asset('admin_assets/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('admin_assets/app-assets/js/core/app.js') }}"></script>

{{--custom js--}}
<script src="{{ mix('admin_assets/app.js') }}"></script>

<script>
    $(window).on('load', function () {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
</body>
<!-- END: Body-->

</html>
