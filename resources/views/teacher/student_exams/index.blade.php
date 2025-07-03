@php use App\Enums\StudentExamStatusEnum; @endphp
@extends('layouts.teacher.app')

@section('content')

    <div class="content-wrapper">

        <div class="content-header row">

            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('student_exams.student_exams')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item active">@lang('student_exams.student_exams')</li>
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

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" id="data-table-search" class="form-control" autofocus placeholder="@lang('site.search')">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select id="status" class="form-control select2" required>
                                            <option value="0">@lang('site.all') @lang('student_exams.statuses')</option>
                                            @foreach (StudentExamStatusEnum::getConstants() as $status)
                                                <option value="{{ $status }}">@lang('student_exams.' . $status)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div><!-- end of row -->

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="table-responsive">

                                        <table class="table datatable" id="student-exams-table" style="width: 100%;">
                                            <thead>
                                            <tr>
                                                <th>@lang('teachers.teacher')</th>
                                                <th>@lang('teachers.examiner')</th>
                                                <th>@lang('students.student')</th>
                                                <th>@lang('projects.project')</th>
                                                <th>@lang('sections.section')</th>
                                                <th>@lang('student_exams.status')</th>
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

            let examinerId = "{{auth()->user()->id}}";
            let status;

            let studentExamsTable = $('#student-exams-table').DataTable({
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
                    url: '{{ route('teacher.student_exams.data') }}',
                    data: function (d) {
                        d.examiner_id = examinerId;
                        d.status = status;
                    }
                },
                columns: [
                    {data: 'teacher', name: 'teacher', searchable: false, sortable: false},
                    {data: 'examiner', name: 'examiner', searchable: false, sortable: false},
                    {data: 'student', name: 'student', searchable: false, sortable: false},
                    {data: 'project', name: 'project', searchable: false, sortable: false},
                    {data: 'section', name: 'section', searchable: false, sortable: false},
                    {data: 'status', name: 'status', searchable: false, sortable: false},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false},
                ],
                order: [[6, 'desc']],
                drawCallback: function (settings) {
                    $('.record__select').prop('checked', false);
                    $('#record__select-all').prop('checked', false);
                    $('#record-ids').val();
                    $('#bulk-delete').attr('disabled', true);
                }
            });


            $('#status').on('change', function () {
                status = $(this).val();
                studentExamsTable.ajax.reload()
            });
            
            $('#data-table-search').keyup(function () {
                studentExamsTable.search(this.value).draw();
            })

        });//end of document ready
    </script>

@endpush