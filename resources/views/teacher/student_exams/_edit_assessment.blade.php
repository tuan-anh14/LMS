@php use App\Enums\AssessmentEnum; @endphp
<form method="post" action="{{ route('teacher.student_exams.update_assessment', $studentExam->id) }}" class="ajax-form">
    @csrf
    @method('put')

    {{--assessment--}}
    <div class="form-group">
        <label>@lang('student_exams.assessment') <span class="text-danger">*</span></label>
        <select name="assessment" class="form-control select2" required>
            <option value="">@lang('site.choose') @lang('student_exams.assessment')</option>
            @foreach (AssessmentEnum::getConstants() as $assessment)
                <option value="{{ $assessment }}">@lang('student_exams.' . $assessment)</option>
            @endforeach
        </select>
    </div>

    {{--notes--}}
    <div class="form-group">
        <label>@lang('student_exams.notes')</label>
        <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i data-feather="edit"></i>@lang('site.edit')</button>
    </div>

</form><!-- end of form -->
