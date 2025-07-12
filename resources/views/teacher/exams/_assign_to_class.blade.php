<form method="post" action="{{ route('teacher.exams.store_assign_to_class', $exam->id) }}" class="assign-to-class-form ajax-form">
  @csrf
  @method('post')

  <input type="hidden" name="exam_id" value="{{ $exam->id }}">

  <div class="form-group">
    <label><strong>Bài kiểm tra:</strong></label>
    <p class="form-control-plaintext">{{ $exam->name }} - {{ $exam->project->name ?? 'N/A' }}</p>
  </div>

  {{--section_id--}}
  <div class="form-group">
    <label>@lang('sections.section') <span class="text-danger">*</span></label>
    <select name="section_id" class="form-control select2" required>
      <option value="">@lang('site.choose') @lang('sections.section')</option>
      @foreach ($sections as $section)
      <option value="{{ $section->id }}">{{ $section->name }}</option>
      @endforeach
    </select>
    @if($sections->isEmpty())
    <small class="text-danger">Không có lớp học nào khả dụng cho môn học này.</small>
    @endif
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
    @if($examiners->isEmpty())
    <small class="text-danger">Không có giám khảo nào khả dụng.</small>
    @endif
  </div>

  {{--date--}}
  <div class="form-group">
    <label>@lang('student_exams.date') <span class="text-danger">*</span></label>
    <input type="text" name="date" class="form-control date-picker" value="{{ old('date') }}" required>
  </div>

  {{--time--}}
  <div class="form-group">
    <label>@lang('student_exams.time') <span class="text-danger">*</span></label>
    <input type="text" name="time" class="form-control time-picker" value="{{ old('time') }}" required>
  </div>

  <div class="alert alert-info">
    <i class="fas fa-info-circle mr-2"></i>
    <strong>Lưu ý:</strong> Bài kiểm tra sẽ được giao cho tất cả sinh viên trong lớp học đã chọn với ngày giờ thi đã thiết lập.
    Nếu sinh viên đã được giao bài này trước đó, hệ thống sẽ bỏ qua.
  </div>

  <div class="form-group">
    <button type="submit" class="btn btn-primary"
      {{ $sections->isEmpty() || $examiners->isEmpty() ? 'disabled' : '' }}>
      <i data-feather="plus"></i> Giao bài cho cả lớp
    </button>
  </div>

</form><!-- end of form -->