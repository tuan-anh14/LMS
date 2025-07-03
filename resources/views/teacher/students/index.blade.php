@php use App\Enums\GenderEnum; @endphp
@extends('layouts.teacher.app')

@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('students.students')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}"
                                                               wire:navigate>@lang('site.home')</a></li>
                                <li class="breadcrumb-item active">@lang('students.students')</li>
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

                                    @if (auth()->user()->hasPermission('create_students', session('selected_center')['id']))
                                        <a href="{{ route('teacher.students.create') }}" class="btn btn-primary"><i
                                                data-feather="plus"></i> @lang('site.create')</a>
                                    @endif

                                    @if (auth()->user()->hasPermission('delete_students', session('selected_center')['id']))
                                        <form method="post" action="{{ route('teacher.students.bulk_delete') }}"
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
                                        <input type="text" id="data-table-search" class="form-control" autofocus
                                               placeholder="@lang('site.search')">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="country-id" class="form-control select2" required>
                                            <option value="0">@lang('site.all') @lang('countries.countries')</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                        data-governorates-url="{{ route('teacher.countries.governorates', $country->id) }}"
                                                >
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="governorate-id" class="form-control select2" disabled>
                                            <option
                                                value="0">@lang('site.all') @lang('governorates.governorates')</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select id="section-id" class="form-control select2" required>
                                            <option value="">@lang('site.all') @lang('sections.sections')</option>
                                            @foreach ($sections as $section)
                                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                @if (auth()->user()->hasRole('center_manager', session('selected_center')['id']))

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <select id="gender" class="form-control select2" required>
                                                <option value="0">@lang('site.all') @lang('users.genders')</option>
                                                @foreach ([GenderEnum::MALE, GenderEnum::FEMALE] as $gender)
                                                    <option value="{{ $gender }}">@lang('users.' . $gender)</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                @endif

                            </div><!-- end of row -->

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="table-responsive">

                                        <table class="table datatable" id="students-table" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>@lang('users.name')</th>
                                                <th>@lang('users.email')</th>
                                                <th>@lang('countries.country')</th>
                                                <th>@lang('governorates.governorate')</th>
                                                <th>@lang('site.created_at')</th>
                                                <th style="width: 20%;">@lang('site.action')</th>
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

            let countryId;
            let governorateId;
            let gender;
            let sectionId;

            let studentsTable = $('#students-table').DataTable({
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
                    url: '{{ route('teacher.students.data') }}',
                    data: function (d) {
                        d.country_id = countryId;
                        d.governorate_id = governorateId;
                        d.section_id = sectionId;
                        d.gender = gender;
                    }
                },
                columns: [
                    {data: 'full_name', name: 'full_name'},
                    {data: 'email', name: 'email'},
                    {data: 'country', name: 'country', sortable: false, searchable: false},
                    {data: 'governorate', name: 'governorate', sortable: false, searchable: false},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                ],
                order: [[5, 'desc']],
                drawCallback: function (settings) {
                    $('.record__select').prop('checked', false);
                    $('#record__select-all').prop('checked', false);
                    $('#record-ids').val();
                    $('#bulk-delete').attr('disabled', true);
                }
            });

            $('#country-id').change(function () {
                countryId = $(this).val();
                studentsTable.ajax.reload();
            });

            $('#governorate-id').change(function () {
                governorateId = $(this).val();
                studentsTable.ajax.reload();
            });

            $('#section-id').change(function () {
                sectionId = $(this).val();
                studentsTable.ajax.reload();
            });

            $('#gender').change(function () {
                gender = $(this).val();
                studentsTable.ajax.reload();
            });

            $('#data-table-search').keyup(function () {
                studentsTable.search(this.value).draw();
            })

        });//end of document ready
    </script>

@endpush
