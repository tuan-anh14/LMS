@php use App\Enums\AssessmentEnum;use App\Enums\AttendanceStatusEnum; @endphp
<form method="post" action="{{ route('examiner.student_exams.store') }}" class="ajax-form">
    @csrf
    @method('post')

    <input type="hidden" name="student_id" value="{{ $student->id }}">

    {{--exam_id--}}
    <div class="form-group">
        <label>@lang('exams.exam') <span class="text-danger">*</span></label>
        <select name="exam_id" class="form-control select2" required>
            <option value="">@lang('site.choose') @lang('exams.exam')</option>
            @foreach ($exams as $exam)
                <option value="{{ $exam->id }}">{{ $exam->name }}</option>
            @endforeach
        </select>
    </div>

    {{--examiner_id--}}
    <div class="form-group">
        <label>@lang('teachers.examiner') <span class="text-danger">*</span></label>
        <select name="examiner_id" class="form-control select2" required>
            <option value="">@lang('site.choose') @lang('teachers.examiner')</option>
            @foreach ($examiners as $examiner)
                <option value="{{ $examiner->id }}">{{ $examiner->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i data-feather="plus"></i> @lang('site.add')</button>
    </div>

</form><!-- end of form -->
