<div class="row">

    <div class="col-md-6">

        <table class="table table-striped">

            <tr>
                <th style="width: 30%;">@lang('users.name')</th>
                <td>{{ $student->full_name }}</td>
            </tr>

            <tr>
                <th>@lang('users.email')</th>
                <td>{{ $student->email }}</td>
            </tr>

            <tr>
                <th>@lang('users.mobile')</th>
                <td>{{ $student->mobile }}</td>
            </tr>

            <tr>
                <th>@lang('users.gender')</th>
                <td>@lang('users.' . $student->gender)</td>
            </tr>

            <tr>
                <th>@lang('countries.country')</th>
                <td>{{ $student->country->name }}</td>
            </tr>

            <tr>
                <th>@lang('governorates.governorate')</th>
                <td>{{ $student->governorate->name }}</td>
            </tr>

            <tr>
                <th>@lang('users.address')</th>
                <td>{{ $student->address }}</td>
            </tr>

            <tr>
                <th>@lang('users.dob')</th>
                <td>{{ $student->dob->format('Y-m-d') }}</td>
            </tr>

        </table>

    </div>

    <div class="col-md-6">

        <table class="table table-striped">

            <tr>
                <th style="width: 30%;">@lang('centers.center')</th>
                <td>{{ $student->studentCenter->name }}</td>
            </tr>

            <tr>
                <th>@lang('projects.project')</th>
                <td>{{ $student->studentProject->name }}</td>
            </tr>

            <tr>
                <th>@lang('sections.section')</th>
                <td>{{ $student->sectionAsStudent->name }}</td>
            </tr>

            <tr>
                <th>@lang('users.logs_count')</th>
                <td>{{ $student->logs_as_student_count }}</td>
            </tr>
        </table>

    </div>

</div>
