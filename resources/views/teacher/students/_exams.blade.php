@php use App\Enums\AssessmentEnum;use App\Enums\AttendanceStatusEnum;use App\Enums\StudentExamStatusEnum; @endphp

<div class="row mb-1">

    <div class="col-md-12">

        <a href="" class="btn btn-primary ajax-modal"
           data-url="{{ route('teacher.student_exams.create', ['student_id' => $student->id]) }}"
           data-modal-title="@lang('exams.new_exam')"
        >
            <i data-feather="plus"></i> @lang('exams.new_exam')
        </a>

    </div>

</div><!-- end of row -->

<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <select id="project-id" class="form-control select2" required>
                <option value="0">@lang('site.all') @lang('projects.project')</option>
                @foreach ($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <select id="status" class="form-control select2" required>
                <option value="0">@lang('site.all') @lang('exams.statuses')</option>
                @foreach (StudentExamStatusEnum::getConstants() as $status)
                    <option value="{{ $status }}">@lang('student_exams.' . $status)</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <select id="assessment" class="form-control select2" required>
                <option value="0">@lang('site.all') @lang('pages.assessments')</option>
                @foreach (AssessmentEnum::getConstants() as $assessment)
                    <option value="{{ $assessment }}">@lang('pages.' . $assessment)</option>
                @endforeach
            </select>
        </div>
    </div>


</div><!-- end of row -->

<div class="row">

    <div class="col-md-12">

        <div class="table-responsive">

            <table class="table datatable" id="pages-table" style="width: 100%;">
                <thead>
                <tr>
                    <th>@lang('teachers.teacher')</th>
                    <th>@lang('projects.project')</th>
                    <th>@lang('sections.section')</th>
                    <th>@lang('teachers.examiner')</th>
                    <th>@lang('exams.status')</th>
                    <th>@lang('exams.assessment')</th>
                    <th>@lang('site.created_at')</th>
                    <th style="width: 15%;">@lang('site.action')</th>
                </tr>
                </thead>
            </table>

        </div><!-- end of table responsive -->

    </div><!-- end of col -->

</div><!-- end of row -->

<script>

    $(function () {

        let studentId = "{{ $student->id }}";
        let projectId;
        let status;
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
                url: '{{ route('teacher.student_exams.data', $student->id) }}',
                data: function (d) {
                    d.student_id = studentId;
                    d.project_id = projectId;
                    d.assessment = assessment;
                    d.status = status;
                }
            },
            columns: [
                {data: 'teacher', name: 'teacher', searchable: false, sortable: false},
                {data: 'project', name: 'project', searchable: false, sortable: false},
                {data: 'section', name: 'section', searchable: false, sortable: false},
                {data: 'examiner', name: 'examiner', searchable: false, sortable: false},
                {data: 'status', name: 'status', searchable: false, sortable: false},
                {data: 'assessment', name: 'assessment', searchable: false, sortable: false},
                {data: 'created_at', name: 'created_at', searchable: false},
                {data: 'actions', name: 'actions', sortable: false, searchable: false},
            ],
            order: [[6, 'desc']],
            drawCallback: function (settings) {
                $('.record__select').prop('checked', false);
                $('#record__select-all').prop('checked', false);
                $('#record-ids').val();
                $('#bulk-delete').attr('disabled', true);
            }
        });

        $('#project-id').change(function () {
            projectId = $(this).val();
            pagesTable.ajax.reload();
        });

        $('#assessment').change(function () {
            assessment = $(this).val();
            pagesTable.ajax.reload();
        });

        $('#status').change(function () {
            status = $(this).val();
            pagesTable.ajax.reload();
        });

        $('#data-table-search').keyup(function () {
            pagesTable.search(this.value).draw();
        })

    });//end of document ready

</script>