<div class="row">

    <div class="col-md-4">
        <div class="form-group">
            <input type="text" id="data-table-search" class="form-control" autofocus placeholder="@lang('site.search')">
        </div>
    </div>

</div><!-- end of row -->

<div class="row">

    <div class="col-md-12">

        <div class="table-responsive">

            <table class="table datatable" id="logs-table" style="width: 100%;">
                <thead>
                <tr>
                    <th>@lang('centers.center')</th>
                    <th>@lang('projects.project')</th>
                    <th>@lang('sections.section')</th>
                    <th>@lang('logs.action_by_user')</th>
                    <th>@lang('site.created_at')</th>
                </tr>
                </thead>
            </table>

        </div><!-- end of table responsive -->

    </div><!-- end of col -->

</div><!-- end of row -->

<script>

    $(function () {

        window.initSelect2();

        let logsTable = $('#logs-table').DataTable({
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
                url: '{{ route('student.logs.data') }}',
                data: function (d) {

                }
            },
            columns: [
                {data: 'center', name: 'center', searchable: false, sortable: false},
                {data: 'project', name: 'project', searchable: false, sortable: false},
                {data: 'section', name: 'section', searchable: false, sortable: false},
                {data: 'action_by_user', name: 'action_by_user', searchable: false, sortable: false},
                {data: 'created_at', name: 'created_at', searchable: false},
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
            logsTable.ajax.reload();
        });

        $(document).on('change', '#project-id', function () {
            projectId = $(this).val();
            logsTable.ajax.reload();
        });

        $(document).on('change', '#section-id', function () {
            sectionId = $(this).val();
            logsTable.ajax.reload();
        });

        $('#data-table-search').keyup(function () {
            logsTable.search(this.value).draw();
        })


    });//end of document ready

</script>