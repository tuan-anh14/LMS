@extends('layouts.admin.app')
@section('title')@lang('sections.sections')@endsection
@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('sections.sections')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item active">@lang('sections.sections')</li>
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

                            <div class="row mb-1">

                                <div class="col-md-12">

                                    @if (auth()->user()->hasPermission('create_sections'))
                                        <a href="{{ route('admin.sections.create') }}" wire:navigate class="btn btn-primary"><i data-feather="plus"></i> @lang('site.create')</a>
                                    @endif

                                    @if (auth()->user()->hasPermission('delete_sections'))
                                        <form method="post" action="{{ route('admin.sections.bulk_delete') }}" class="ajax-form" style="display: inline-block;">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="record_ids" id="record-ids">
                                            <button type="submit" class="btn btn-danger" id="bulk-delete" disabled="true"><i data-feather="trash-2"></i> @lang('site.bulk_delete')</button>
                                        </form><!-- end of form -->
                                    @endif

                                </div>

                            </div><!-- end of row -->

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="data-table-search" class="form-control" autofocus placeholder="@lang('site.search')">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="center-id" class="form-control select2" required>
                                            <option value="0">@lang('site.all') @lang('centers.centers')</option>
                                            @foreach ($centers as $center)
                                                <option value="{{ $center->id }}"
                                                        data-projects-url="{{ route('admin.centers.projects', $center->id) }}"
                                                >
                                                    {{ $center->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="project-id" class="form-control select2" required disabled>
                                            <option value="0">@lang('site.all') @lang('projects.projects')</option>
                                        </select>
                                    </div>
                                </div>

                            </div><!-- end of row -->

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="table-responsive">

                                        <table class="table datatable" id="sections-table" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="record__select-all">
                                                        <label class="custom-control-label" for="record__select-all"></label>
                                                    </div>
                                                </th>
                                                <th>@lang('sections.name')</th>
                                                <th>@lang('centers.center')</th>
                                                <th>@lang('projects.project')</th>
                                                <th>@lang('site.created_at')</th>
                                                <th>@lang('site.action')</th>
                                            </tr>
                                            </thead>
                                        </table>

                                    </div><!-- end of table responsive -->

                                </div><!-- end of col -->

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

            let centerId;
            let projectId;

            let sectionsTable = $('#sections-table').DataTable({
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
                    url: '{{ route('admin.sections.data') }}',
                    data: function (d) {
                        d.center_id = centerId;
                        d.project_id = projectId;
                    }
                },
                columns: [
                    {data: 'record_select', name: 'record_select', searchable: false, sortable: false, width: '1%'},
                    {data: 'name', name: 'name'},
                    {data: 'center', name: 'center', searchable: false, sortable: false},
                    {data: 'project', name: 'project', searchable: false, sortable: false},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                ],
                order: [[4, 'desc']],
                drawCallback: function (settings) {
                    $('.record__select').prop('checked', false);
                    $('#record__select-all').prop('checked', false);
                    $('#record-ids').val();
                    $('#bulk-delete').attr('disabled', true);
                }
            });

            $('#center-id').change(function () {
                centerId = $(this).val();
                sectionsTable.ajax.reload();
            });

            $(document).on('change', '#project-id', function () {
                projectId = $(this).val();
                sectionsTable.ajax.reload();
            });

            $('#data-table-search').keyup(function () {
                sectionsTable.search(this.value).draw();
            })

        });//end of document ready
    </script>

@endpush
