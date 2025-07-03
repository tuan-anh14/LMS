@extends('layouts.admin.app')
@section('title')@lang('inquiries.inquiries')@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('inquiries.inquiries')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}" wire:navigate>@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.inquiries.index') }}" wire:navigate>@lang('inquiries.inquiries')</a></li>
                                <li class="breadcrumb-item active">@lang('inquiries.inquiries')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end of content header -->

        <div class="content-body">

            <div class="row">

                <div class="col-md-12">

                    <div class="card">

                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-12">

                                    <table class="table table-striped">

                                        <tr>
                                            <th style="width: 15%;">@lang('inquiries.title')</th>
                                            <td>{{ $inquiry->title }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('inquiries.body')</th>
                                            <td>{{ $inquiry->message }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('inquiries.email')</th>
                                            <td>{{ $inquiry->email }}</td>
                                        </tr>

                                        <tr>
                                            <th>@lang('inquiries.email')</th>
                                            <td>{{ $inquiry->created_at->format('Y-m-d h:i a') }}</td>
                                        </tr>

                                    </table>

                                </div>

                            </div><!-- end of row -->

                        </div><!-- end of card body -->

                    </div><!-- end of card -->

                </div><!-- end of col -->

            </div><!-- end of row -->

        </div><!-- end of content body -->

    </div><!-- end of content wrapper -->

@endsection

@push('scripts')

    <script>

        $(function () {

            let inquiriesTable = $('#inquiries-table').DataTable({
                dom: "tiplr",
                buttons: [
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: [1, 2, 3]
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [1, 2, 3]
                        }
                    },
                ],
                serverSide: true,
                processing: true,
                "language": {
                    "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
                },
                ajax: {
                    url: '{{ route('admin.inquiries.data') }}',
                },
                columns: [
                    {data: 'record_select', name: 'record_select', searchable: false, sortable: false, width: '1%'},
                    {data: 'title', name: 'title'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                ],
                order: [[3, 'desc']],
                drawCallback: function (settings) {
                    $('.record__select').prop('checked', false);
                    $('#record__select-all').prop('checked', false);
                    $('#record-ids').val();
                    $('#bulk-delete').attr('disabled', true);
                }
            });

            $('#data-table-search').keyup(function () {
                inquiriesTable.search(this.value).draw();
            })

        });//end of document ready
    </script>

@endpush
