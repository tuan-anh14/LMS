<form method="post" action="{{ route('examiner.student_exams.update_date_time', $studentExam->id) }}" class="ajax-form">
    @csrf
    @method('put')

    {{--date--}}
    <div class="form-group">
        <label>@lang('student_exams.date') <span class="text-danger">*</span></label>
        <input type="text" name="date" class="form-control date-picker" value="{{ old('date', $studentExam->date) }}"
               required>
    </div>

    {{--time--}}
    <div class="form-group">
        <label>@lang('student_exams.time') <span class="text-danger">*</span></label>
        <input type="text" name="time" class="form-control time-picker" value="{{ old('time', $studentExam->time) }}"
               required>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary"><i data-feather="edit"></i>@lang('site.edit')</button>
    </div>

</form><!-- end of form -->
