@php use App\Enums\AttendanceStatusEnum; @endphp
<div class="row mb-1">

    <div class="col-md-12">

        <a href="" class="btn btn-primary ajax-modal"
           data-url="{{ route('teacher.student_lectures.create', ['student_id' => $student->id]) }}"
           data-modal-title="@lang('lectures.new_lecture')"
        >
            <i data-feather="plus"></i> @lang('lectures.new_lecture')
        </a>

    </div>

</div><!-- end of row -->

<div class="row">

    <div class="col-md-6">
        <div class="form-group">
            <input type="text" id="date-range" class="form-control date-range-picker" value="" placeholder="@lang('site.choose') @lang('lectures.date')">
            <input type="hidden" id="from-date">
            <input type="hidden" id="to-date">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <select id="attendance-status" class="form-control select2" required>
                <option value="0">@lang('site.all') @lang('lectures.attendance_statuses')</option>
                @foreach (AttendanceStatusEnum::getConstants() as $attendanceStatus)
                    <option value="{{ $attendanceStatus }}">@lang('lectures.' . $attendanceStatus)</option>
                @endforeach
            </select>
        </div>
    </div>

</div><!-- end of row -->

<div class="row">

    <div class="col-md-12">

        <div class="table-responsive">

            <table class="table datatable" id="lectures-table" style="width: 100%;">
                <thead>
                <tr>
                    <th>@lang('lectures.name')</th>
                    <th>@lang('centers.center')</th>
                    <th>@lang('sections.section')</th>
                    <th>@lang('lectures.attendance_status')</th>
                    <th>@lang('site.created_at')</th>
                    <th>@lang('site.action')</th>
                </tr>
                </thead>
            </table>

        </div><!-- end of table responsive -->

    </div><!-- end of col -->

</div><!-- end of row -->

<script>

    $(function () {

        let sectionId;
        let studentId = "{{ $student->id }}";
        let dateRange = {};
        let attendanceStatus;

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
                url: '{{ route('teacher.student_lectures.data') }}',
                data: function (d) {
                    d.student_id = studentId;
                    d.section_id = sectionId;
                    d.date_range = dateRange;
                    d.attendance_status = attendanceStatus;
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'center', name: 'center', searchable: false, sortable: false},
                {data: 'section', name: 'section', searchable: false, sortable: false},
                {data: 'attendance_status', name: 'attendance_status', searchable: false, sortable: false},
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

        $('#to-date').on('change', function (e) {

            dateRange['from'] = $('#from-date').val();
            dateRange['to'] = $('#to-date').val();

            lecturesTable.ajax.reload();

        })

        $('#attendance-status').change(function () {
            attendanceStatus = $(this).val();
            lecturesTable.ajax.reload();
        });

        $('#data-table-search').keyup(function () {
            lecturesTable.search(this.value).draw();
        })

    });//end of document ready

</script>