<div class="row">

    <div class="col-md-6">

        <table class="table table-striped">

            <tr>
                <th style="width: 30%;">id</th>
                <td>{{ $teacher->id }}</td>
            </tr>

            <tr>
                <th>@lang('users.name')</th>
                <td>{{ $teacher->full_name }}</td>
            </tr>

            <tr>
                <th>@lang('users.email')</th>
                <td>{{ $teacher->email }}</td>
            </tr>

            <tr>
                <th>@lang('users.mobile')</th>
                <td>{{ $teacher->mobile }}</td>
            </tr>

            <tr>
                <th>@lang('users.gender')</th>
                <td>@lang('users.' . $teacher->gender)</td>
            </tr>

            <tr>
                <th>@lang('countries.country')</th>
                <td>{{ $teacher->country->name }}</td>
            </tr>

            <tr>
                <th>@lang('governorates.governorate')</th>
                <td>{{ $teacher->governorate->name }}</td>
            </tr>

            <tr>
                <th>@lang('users.address')</th>
                <td>{{ $teacher->address }}</td>
            </tr>

            <tr>
                <th>@lang('users.dob')</th>
                <td>{{ $teacher->dob->format('Y-m-d') }}</td>
            </tr>

        </table>

    </div>

    <div class="col-md-6">

        <table class="table table-striped">

            <tr>
                <th>@lang('degrees.degree')</th>
                <td>{{ $teacher->degree->name }}</td>
            </tr>

            <tr>
                <th style="width: 30%;">@lang('centers.center')</th>
                <td>
                    @foreach ($teacher->teacherCenters as $teacherCenter)
                        <span class="badge badge-primary">{{ $teacherCenter->name }}</span>
                    @endforeach
                </td>
            </tr>

            <tr>
                <th style="width: 30%;">@lang('teachers.is_center_manager')</th>
                <td>
                    @foreach ($teacher->managerCenters as $managerCenter)
                        <span class="badge badge-primary">{{ $managerCenter->name }}</span>
                    @endforeach
                </td>
            </tr>

            <tr>
                <th>@lang('teachers.is_examiner')</th>
                <td>{{ $teacher->isExaminer() ? __('site.yes') : __('site.no')}}</td>
            </tr>

        </table>

    </div>

</div>
