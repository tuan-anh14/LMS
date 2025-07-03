<div class="row">

    <div class="col-md-6">

        <table class="table table-striped">

            <tr>
                <th style="width: 30%;">@lang('users.name')</th>
                <td>{{ auth()->user()->full_name }}</td>
            </tr>

            <tr>
                <th>@lang('users.email')</th>
                <td>{{ auth()->user()->email }}</td>
            </tr>

            <tr>
                <th>@lang('users.mobile')</th>
                <td>{{ auth()->user()->mobile }}</td>
            </tr>

            <tr>
                <th>@lang('users.gender')</th>
                <td>@lang('users.' . auth()->user()->gender)</td>
            </tr>

            <tr>
                <th>@lang('countries.country')</th>
                <td>{{ auth()->user()->country->name }}</td>
            </tr>

            <tr>
                <th>@lang('governorates.governorate')</th>
                <td>{{ auth()->user()->governorate->name }}</td>
            </tr>

            <tr>
                <th>@lang('users.address')</th>
                <td>{{ auth()->user()->address }}</td>
            </tr>

            <tr>
                <th>@lang('users.dob')</th>
                <td>{{ auth()->user()->dob->format('Y-m-d') }}</td>
            </tr>

        </table>

    </div>

    <div class="col-md-6">

        <table class="table table-striped">

            <tr>
                <th style="width: 30%;">@lang('centers.center')</th>
                <td>{{ auth()->user()->studentCenter->name }}</td>
            </tr>

            <tr>
                <th>@lang('projects.project')</th>
                <td>{{ auth()->user()->studentProject->name }}</td>
            </tr>

            <tr>
                <th>@lang('sections.section')</th>
                <td>{{ auth()->user()->sectionAsStudent->name }}</td>
            </tr>

            <tr>
                <th>@lang('users.logs_count')</th>
                <td>{{ auth()->user()->logs_as_student_count }}</td>
            </tr>
        </table>

    </div>

</div>
