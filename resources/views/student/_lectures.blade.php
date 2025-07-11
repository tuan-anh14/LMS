@php use App\Enums\LectureTypeEnum; @endphp

<div class="row mb-1">

    <div class="col-md-12">

        <h4 class="mb-2">@lang('lectures.lectures')</h4>

    </div>

</div><!-- end of row -->

<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <input type="text" id="date-range" class="form-control date-range-picker" value="" placeholder="@lang('site.choose') @lang('lectures.date')">
            <input type="hidden" id="from-date">
            <input type="hidden" id="to-date">
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <select id="lecture-type" class="form-control select2" required>
                <option value="0">@lang('site.all') @lang('lectures.types')</option>
                <option value="{{ \App\Enums\LectureTypeEnum::EDUCATIONAL }}">@lang('lectures.educational')</option>
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
                    <th>@lang('lectures.teacher')</th>
                    <th>@lang('centers.center')</th>
                    <th>@lang('sections.section')</th>
                    <th>@lang('lectures.type')</th>
                    <th>@lang('lectures.date')</th>
                    <th>@lang('site.created_at')</th>
                </tr>
                </thead>
            </table>

        </div><!-- end of table responsive -->

    </div><!-- end of col -->

</div><!-- end of row -->

<script>

    $(function () {

        let dateRange = {};
        let lectureType;

        let lecturesTable = $('#lectures-table').DataTable({
            dom: "tiplr",
            buttons: [
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6]
                    }
                },
            ],
            serverSide: true,
            processing: true,
            "language": {
                "url": "{{ asset('admin_assets/datatable-lang/' . app()->getLocale() . '.json') }}"
            },
            ajax: {
                url: "{{ route('student.lectures.data') }}",
                data: function (d) {
                    d.date_range = dateRange;
                    d.type = lectureType;
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'teacher', name: 'teacher', searchable: false, sortable: false},
                {data: 'center', name: 'center', searchable: false, sortable: false},
                {data: 'section', name: 'section', searchable: false, sortable: false},
                {data: 'type', name: 'type', searchable: false, sortable: false},
                {data: 'date', name: 'date', searchable: false, sortable: true},
                {data: 'created_at', name: 'created_at', searchable: false},
            ],
            order: [[5, 'desc']],
            drawCallback: function (settings) {
                // Callback after drawing
            }
        });

        $('#to-date').on('change', function (e) {
            dateRange['from'] = $('#from-date').val();
            dateRange['to'] = $('#to-date').val();
            lecturesTable.ajax.reload();
        });

        $('#lecture-type').change(function () {
            lectureType = $(this).val();
            lecturesTable.ajax.reload();
        });

        $('#data-table-search').keyup(function () {
            lecturesTable.search(this.value).draw();
        });

    });//end of document ready

</script> 