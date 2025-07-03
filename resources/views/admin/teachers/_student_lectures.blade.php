@php use App\Enums\LectureTypeEnum; @endphp
<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <select id="center-id" class="form-control select2" required>
                <option value="0">@lang('site.all') @lang('centers.centers')</option>
                @foreach ($centers as $center)
                    <option value="{{ $center->id }}">{{ $center->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <select id="type" class="form-control select2" required>
                <option value="0">@lang('site.all') @lang('lectures.types')</option>
                @foreach (LectureTypeEnum::getConstants() as $type)
                    <option value="{{ $type }}">@lang('student_lectures.' . $type)</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <input type="text" id="date-range" class="form-control date-range-picker" value=""
                   placeholder="@lang('site.choose') @lang('lectures.date')">
            <input type="hidden" id="from-date">
            <input type="hidden" id="to-date">
        </div>
    </div>

</div><!-- end of row -->

<div class="row">

    <div class="col-md-12">

        <div class="table-responsive">

            <table class="table datatable" id="student-lectures-table" style="width: 100%;">
                <thead>
                <tr>
                    <th>@lang('lectures.name')</th>
                    <th>@lang('centers.center')</th>
                    <th>@lang('sections.section')</th>
                    <th>@lang('lectures.type')</th>
                    <th>@lang('student_lectures.attended_students_count')</th>
                    <th>@lang('student_lectures.absent_students_count')</th>
                    <th>@lang('student_lectures.excuse_students_count')</th>
                    <th>@lang('site.created_at')</th>
                    {{--<th>@lang('site.action')</th>--}}
                </tr>
                </thead>
            </table>

        </div><!-- end of table responsive -->

    </div><!-- end of col -->

</div><!-- end of row -->

<script>

    $(function () {

        let teacherId = "{{ $teacher->id }}";
        let centerId;
        let type;
        let dateRange = {};

        let studentLecturesTable = $('#student-lectures-table').DataTable({
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
                url: '{{ route('admin.student_lectures.data') }}',
                data: function (d) {
                    d.teacher_id = teacherId;
                    d.center_id = centerId;
                    d.type = type;
                    d.date_range = dateRange;
                }
            },
            columns: [
                // {data: 'record_select', name: 'record_select', searchable: false, sortable: false, width: '1%'},
                {data: 'name', name: 'name'},
                {data: 'center', name: 'center', searchable: false, sortable: false},
                {data: 'section', name: 'section', searchable: false, sortable: false},
                {data: 'type', name: 'type', searchable: false, sortable: false},
                {data: 'attended_students_count', name: 'attended_students_count', searchable: false},
                {data: 'absent_students_count', name: 'absent_students_count', searchable: false},
                {data: 'excuse_students_count', name: 'excuse_students_count', searchable: false},
                {data: 'created_at', name: 'created_at', searchable: false},
                // {data: 'actions', name: 'actions', searchable: false, sortable: false},
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
            studentLecturesTable.ajax.reload();
        });

        $('#type').change(function () {
            type = $(this).val();
            studentLecturesTable.ajax.reload();
        });

        $('#to-date').on('change', function (e) {

            dateRange['from'] = $('#from-date').val();
            dateRange['to'] = $('#to-date').val();

            studentLecturesTable.ajax.reload();

        })

        $('#data-table-search').keyup(function () {
            studentLecturesTable.search(this.value).draw();
        })

    });//end of document ready

</script>
