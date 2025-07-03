@php use App\Enums\AssessmentEnum;use App\Enums\AttendanceStatusEnum; @endphp
<form method="post"
      action="{{ route('examiner.student_exams.update', ['student' => $student->id, 'lecture' => $lecture->id,]) }}"
      class="ajax-form">
    @csrf
    @method('put')

    {{--center_id--}}
    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                <label>@lang('centers.center') <span class="text-danger">*</span></label>
                <select name="center_id" class="form-control select2" disabled>
                    <option value="">{{ $student->studentCenter->name }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>@lang('sections.section') <span class="text-danger">*</span></label>
                <select name="section_id" class="form-control select2" disabled>
                    <option value="">{{ $student->studentSection->name }}</option>
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>@lang('projects.project') <span class="text-danger">*</span></label>
                <select name="project_id" class="form-control select2" disabled>
                    <option value="">{{ $student->studentProject->name }}</option>
                </select>
            </div>
        </div>

    </div><!-- end of row -->

    {{--lectures--}}
    <div class="form-group">
        <label>@lang('lectures.lecture') <span class="text-danger">*</span></label>
        <select name="lecture_id" class="form-control select2" disabled>
            <option value="{{ $lecture->name }}">{{ $lecture->name }}</option>
        </select>
    </div>

    {{--status--}}
    <div class="form-group">
        <label>@lang('lectures.attendance_status') <span class="text-danger">*</span></label>
        <select name="attendance_status" id="attendance-status" class="form-control select2" required>
            <option value="">@lang('lectures.attendance_status')</option>
            @foreach (AttendanceStatusEnum::getConstants() as $attendanceStatus)
                <option
                    value="{{ $attendanceStatus }}" {{ $attendanceStatus == $lecture->pivot->attendance_status ? 'selected' : '' }}>@lang('lectures.' . $attendanceStatus)</option>
            @endforeach
        </select>
    </div>

    <div id="pages-wrapper" style="display: {{ $student->attendedLecture($lecture) ? 'block' : 'none' }}">

        <h4 class="mr-2 mt-2">@lang('pages.pages')</h4>

        <div id="pages-row-wrapper">

            @php
                $pages = $student->studentPages()
                    ->where('teacher_id', auth()->user()->id)
                    ->where('lecture_id', $lecture->id)
                    ->where('book_id', $student->studentProject->book_id)
                    ->get()
            @endphp

            @if ($pages->count() > 0)

                @foreach ($pages as $index => $page)

                    <div class="row page-row">

                        {{--from--}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('pages.from') <span class="text-danger">*</span></label>
                                <input type="text" name="pages[{{ $index }}][from]" class="form-control"
                                       value="{{ old('from', $page->from) }}" required>
                            </div>
                        </div>

                        {{--to--}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>@lang('pages.to') <span class="text-danger">*</span></label>
                                <input type="text" name="pages[{{ $index }}][to]" class="form-control"
                                       value="{{ old('to', $page->to) }}" required>
                            </div>
                        </div>

                        {{--assessment--}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>@lang('pages.assessment') <span class="text-danger">*</span></label>
                                <select name="pages[{{ $index }}][assessment]" class="form-control select2" required>
                                    <option value="">@lang('site.choose') @lang('pages.assessment')</option>
                                    @foreach (AssessmentEnum::getConstants() as $assessment)
                                        <option
                                            value="{{ $assessment }}" {{ $assessment == $page->assessment ? 'selected' : '' }}>@lang('pages.' . $assessment)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-outline-danger w-100 delete-page-btn text-danger" disabled
                                    style="margin-top: 24px;"><i data-feather="trash"></i></button>
                        </div>

                    </div>

                @endforeach

            @else

                <div class="row page-row">

                    {{--from--}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('pages.from') <span class="text-danger">*</span></label>
                            <input type="text" name="pages[0][from]" class="form-control" value="{{ old('from') }}"
                                   disabled>
                        </div>
                    </div>

                    {{--to--}}
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>@lang('pages.to') <span class="text-danger">*</span></label>
                            <input type="text" name="pages[0][to]" class="form-control" value="{{ old('to') }}"
                                   disabled>
                        </div>
                    </div>

                    {{--assessment--}}
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>@lang('pages.assessment') <span class="text-danger">*</span></label>
                            <select name="pages[0][assessment]" class="form-control select2" disabled>
                                <option value="">@lang('site.choose') @lang('pages.assessment')</option>
                                @foreach (AssessmentEnum::getConstants() as $assessment)
                                    <option value="{{ $assessment }}">@lang('pages.' . $assessment)</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-outline-danger w-100 delete-page-btn text-danger" disabled
                                style="margin-top: 24px;"><i data-feather="trash"></i></button>
                    </div>

                </div>

            @endif

        </div>

        <div class="mb-2">
            <a href="" id="add-more-pages-btn"><i data-feather="plus"></i> @lang('pages.add_more')</a>
        </div>

    </div>

    {{--notes--}}
    <div class="form-group">
        <label>@lang('lectures.notes') <span class="text-danger">*</span></label>
        <textarea name="notes" class="form-control">{{ old('notes', $lecture->pivot->notes) }}</textarea>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> @lang('site.edit')</button>
    </div>

</form><!-- end of form -->
