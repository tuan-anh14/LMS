@php use App\Enums\LectureTypeEnum; @endphp
@extends('layouts.examiner.app')

@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('lectures.lectures')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}"
                                                               wire:navigate>@lang('site.home')</a></li>
                                <li class="breadcrumb-item active">@lang('lectures.lectures')</li>
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

                                    @if (auth()->user()->hasPermission('create_lectures'))
                                        <a href="{{ route('teacher.lectures.create') }}" wire:navigate
                                           class="btn btn-primary"><i data-feather="plus"></i> @lang('site.create')</a>
                                    @endif

                                    @if (auth()->user()->hasPermission('delete_lectures'))
                                        <form method="post" action="{{ route('teacher.lectures.bulk_delete') }}"
                                              style="display: inline-block;">
                                            @csrf
                                            @method('delete')
                                            <input type="hidden" name="record_ids" id="record-ids">
                                            <button type="submit" class="btn btn-danger" id="bulk-delete"
                                                    disabled="true"><i
                                                    data-feather="trash-2"></i> @lang('site.bulk_delete')</button>
                                        </form><!-- end of form -->
                                    @endif

                                </div>

                            </div><!-- end of row -->

                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="section-id" class="form-control select2" required>
                                            <option value="0">@lang('site.all') @lang('sections.sections')</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="type" class="form-control select2" required>
                                            <option value="0">@lang('site.all') @lang('lectures.types')</option>
                                            @foreach (LectureTypeEnum::getConstants() as $type)
                                                <option value="{{ $type }}">@lang('lectures.' . $type)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <input type="text" id="date-range" class="form-control date-range-picker"
                                               value="" placeholder="@lang('site.choose') @lang('lectures.date')">
                                        <input type="hidden" id="from-date">
                                        <input type="hidden" id="to-date">
                                    </div>
                                </div>

                            </div><!-- end of row -->

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="table-responsive">

                                        <table class="table datatable" id="lectures-table" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="record__select-all">
                                                        <label class="custom-control-label"
                                                               for="record__select-all"></label>
                                                    </div>
                                                </th>
                                                <th>@lang('lectures.name')</th>
                                                <th>@lang('centers.center')</th>
                                                <th>@lang('sections.section')</th>
                                                <th>@lang('lectures.type')</th>
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

            let sectionId;
            let type;
            let dateRange = {};

            let lecturesTable = $('#lectures-table').DataTable({
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
                    url: '{{ route('teacher.lectures.data') }}',
                    data: function (d) {
                        d.section_id = sectionId;
                        d.type = type;
                        d.date_range = dateRange;
                    }
                },
                columns: [
                    {data: 'record_select', name: 'record_select', searchable: false, sortable: false, width: '1%'},
                    {data: 'name', name: 'name'},
                    {data: 'center', name: 'center', searchable: false, sortable: false},
                    {data: 'section', name: 'section', searchable: false, sortable: false},
                    {data: 'type', name: 'type', searchable: false, sortable: false},
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

            $('#section-id').change(function () {
                sectionId = $(this).val();
                lecturesTable.ajax.reload();
            });

            $('#type').change(function () {
                type = $(this).val();
                lecturesTable.ajax.reload();
            });

            $('#to-date').on('change', function (e) {

                dateRange['from'] = $('#from-date').val();
                dateRange['to'] = $('#to-date').val();

                lecturesTable.ajax.reload();

            })

            $('#data-table-search').keyup(function () {
                lecturesTable.search(this.value).draw();
            })

        });//end of document ready
    </script>

@endpush
