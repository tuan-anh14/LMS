<!DOCTYPE html>
<html class="light-layout loaded {{ auth()->user()->layout == 'dark-layout' ? 'dark-layout' : '' }}"
      dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
      data-layout="bordered-layout"
>
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
    <meta name="user-id" content="{{ auth()->user()->id }}">
    <meta name="user-id" content="{{ auth()->user()->id }}">
    <meta name="loading" content="@lang('site.loading')">
    <meta name="no-data-found" content="@lang('site.no_data_found')">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="apple-touch-icon" href="{{ asset('admin_assets/app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin_assets/app-assets/images/ico/favicon.ico') }}">
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
    <script src="{{ asset('admin_assets/app-assets/vendors/js/pickers/flatpickr/flatpickr_ar.js')}}"></script>
    <link rel="stylesheet"
          href="{{ asset('admin_assets/app-assets/vendors/css/easy-autocomplete/easy-autocomplete.min.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <!-- BEGIN: Theme CSS-->
    @if (app()->getLocale() == 'ar')

        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/vendors/css/vendors-rtl.min.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css-rtl/bootstrap.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/bootstrap-extended.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css-rtl/colors.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/components.css') }}?id=1">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/themes/dark-layout.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/themes/bordered-layout.css') }}">
        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/themes/semi-dark-layout.css') }}">

        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">

        <link rel="stylesheet" type="text/css"
              href="{{ asset('admin_assets/app-assets/css-rtl/plugins/forms/form-wizard.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/app-assets/css-rtl/custom-rtl.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/assets/css/style-rtl.css') }}">

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
        <link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/assets/css/style.css') }}">

    @endif

    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin_assets/app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('admin_assets/app-assets/css/plugins/forms/form-validation.css') }}">

    <script src="{{ asset('admin_assets/app-assets/vendors/js/charts/chart.min.js') }}"></script>

    <link rel="stylesheet" href="{{ mix('admin_assets/app.min.css') }}">

    @if (app()->getLocale() ==  'ar')

        {{--google font--}}
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cairo:400,600&display=swap">

        <style>

            html, body, .navigation, .header-navbar {
                font-family: 'cairo', sans-serif !important;
            }

        </style>

    @endif

    @stack('styles')

    @livewireStyles

    <script src="{{ asset('admin_assets/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
    <script
        src="{{ asset('admin_assets/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <script
        src="{{ asset('admin_assets/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin_assets/app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js') }}"></script>

    {{--<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>--}}
    {{--<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>--}}

    <script src="{{ asset('admin_assets/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <script src="{{ asset('admin_assets/app-assets/js/scripts/components/components-collapse.js') }}"></script>

    {{--ckeditor--}}
    <script src="{{ asset('admin_assets/app-assets/vendors/js/ckeditor/build/ckeditor.js') }}"></script>

    {{--custom js--}}
    <script src="{{ mix('admin_assets/app.js') }}"></script>

    <script>

        $(function () {

            //delete
            $(document).on('click', '.btn.delete, .btn#bulk-delete', function (e) {

                var that = $(this)

                e.preventDefault();

                var n = new Noty({
                    text: "@lang('site.confirm_delete')",
                    type: "alert",
                    killer: true,
                    buttons: [
                        Noty.button("@lang('site.yes')", 'btn btn-success mr-2', function () {
                            let url = that.closest('form').attr('action');
                            let data = new FormData(that.closest('form').get(0));

                            let loadingText = $('meta[name="loading-text"]').attr('content');
                            let originalText = that.html();
                            that.html(loadingText);

                            n.close();

                            $.ajax({
                                url: url,
                                data: data,
                                method: 'post',
                                processData: false,
                                contentType: false,
                                cache: false,
                                success: function (response) {

                                    $("#record__select-all").prop("checked", false);

                                    $('.datatable').DataTable().ajax.reload();

                                    new Noty({
                                        layout: 'topRight',
                                        type: 'warning',
                                        text: response['success_message'],
                                        killer: true,
                                        timeout: 2000,
                                    }).show();

                                    that.html(originalText);
                                },

                            });//end of ajax call

                        }),

                        Noty.button("@lang('site.no')", 'btn btn-danger mr-2', function () {
                            n.close();
                        })
                    ]
                });

                n.show();

            });//end of delete

        });//end of document ready

        // $(window).on('load', function () {
        //     if (feather) {
        //         feather.replace({
        //             width: 14,
        //             height: 14
        //         });
        //     }
        // })

    </script>

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-sticky footer-static   menu-expanded" data-open="click"
      data-menu="vertical-menu-modern" data-col="">

@include('layouts.student._header')

@include('layouts.student._aside')

<!-- BEGIN: Content-->
<div class="app-content content ">

    <div class="content-overlay"></div>

    <div class="header-navbar-shadow"></div>

    @include('admin.partials._session')

    @yield('content')

</div>
<!-- END: Content-->

{{--ajax modal--}}
<div class="modal fade text-left" id="ajax-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100">Default Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>

        </div>
    </div>
</div>

{{--error-modal--}}
<div class="modal fade" id="error-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
     aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title w-100">Error</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>

        </div>
    </div>
</div>


<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-dark">
    <p class="clearfix mb-0">
        <span
            class="float-md-left d-block d-md-inline-block mt-25">@lang('site.all_rights_reserved') &copy; {{ now()->year }}<a
                class="ml-25"
                href="https://webseity.com"
                target="_blank">@lang('site.developer_by') @lang('site.webseity')</a>

        </span>
    </p>
</footer>

<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>

@livewireScripts

@stack('scripts')

</body>
</html>
