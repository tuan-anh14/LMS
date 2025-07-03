@php use App\Enums\AssessmentEnum;use App\Enums\AttendanceStatusEnum; @endphp

<div class="row">

    {{--<div class="col-md-6">
        <div class="form-group">
            <select id="lecture-id" class="form-control select2" required>
                <option value="0">@lang('site.all') @lang('lectures.lectures')</option>
                @foreach ($lectures as $lecture)
                    <option value="{{ $lecture->id }}">{{ $lecture->name }}</option>
                @endforeach
            </select>
        </div>
    </div>--}}

    {{--<div class="col-md-6">
        <div class="form-group">
            <select id="assessment" class="form-control select2" required>
                <option value="0">@lang('site.all') @lang('pages.assessments')</option>
                @foreach (AssessmentEnum::getConstants() as $assessment)
                    <option value="{{ $assessment }}">@lang('pages.' . $assessment)</option>
                @endforeach
            </select>
        </div>
    </div>--}}

</div><!-- end of row -->

<div class="row">

    <div class="col-md-12">

        <div class="table-responsive">

            <table class="table datatable" id="pages-table" style="width: 100%;">
                <thead>
                <tr>
                    <th>@lang('sections.section')</th>
                    <th>@lang('books.book')</th>
                    <th>@lang('teachers.teacher')</th>
                    <th>@lang('lectures.lecture')</th>
                    <th>@lang('pages.from')</th>
                    <th>@lang('pages.to')</th>
                    <th>@lang('pages.assessment')</th>
                    <th>@lang('site.created_at')</th>
                </tr>
                </thead>
            </table>

        </div><!-- end of table responsive -->

    </div><!-- end of col -->

</div><!-- end of row -->

<script>

    $(function () {

        let studentId = "{{ $student->id }}";
        let lectureId;
        let assessment;

        let pagesTable = $('#pages-table').DataTable({
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
                url: '{{ route('teacher.pages.data') }}',
                data: function (d) {
                    d.student_id = studentId;
                    d.assessment = assessment;
                    d.lecture_id = lectureId;
                }
            },
            columns: [
                {data: 'section', name: 'section', searchable: false, sortable: false},
                {data: 'book', name: 'book', searchable: false, sortable: false},
                {data: 'teacher', name: 'teacher', searchable: false, sortable: false},
                {data: 'lecture', name: 'lecture', searchable: false, sortable: false},
                {data: 'from', name: 'from', searchable: false},
                {data: 'to', name: 'to', searchable: false},
                {data: 'assessment', name: 'to', searchable: false, sortable: false},
                {data: 'created_at', name: 'created_at', searchable: false},
            ],
            order: [[7, 'desc']],
            drawCallback: function (settings) {
                $('.record__select').prop('checked', false);
                $('#record__select-all').prop('checked', false);
                $('#record-ids').val();
                $('#bulk-delete').attr('disabled', true);
            }
        });

        $('#section-id').change(function () {
            sectionId = $(this).val();
            pagesTable.ajax.reload();
        });

        $('#assessment').change(function () {
            assessment = $(this).val();
            pagesTable.ajax.reload();
        });

        $('#lecture-id').change(function () {
            lectureId = $(this).val();
            pagesTable.ajax.reload();
        });

        $('#data-table-search').keyup(function () {
            pagesTable.search(this.value).draw();
        })

    });//end of document ready

</script>
