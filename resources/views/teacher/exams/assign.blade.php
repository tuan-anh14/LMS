@extends('layouts.teacher.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('exams.assign_to_class')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teacher.exams.index') }}">@lang('exams.exams')</a></li>
                                <li class="breadcrumb-item active">@lang('exams.assign_to_class')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i data-feather="file-text"></i>
                                @lang('exams.assign_exam'): "{{ $exam->name }}"
                            </h4>
                        </div>
                        <div class="card-body">
                            <!-- Flash Messages -->
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    <i data-feather="alert-circle"></i> {{ session('error') }}
                                </div>
                            @endif
                            
                            @if(session('success'))
                                <div class="alert alert-success">
                                    <i data-feather="check-circle"></i> {{ session('success') }}
                                </div>
                            @endif
                            
                            <!-- Exam Info -->
                            <div class="alert alert-info">
                                <h5><i data-feather="info"></i> @lang('exams.exam_info')</h5>
                                <p class="mb-1"><strong>@lang('exams.exam_name'):</strong> {{ $exam->name }}</p>
                                <p class="mb-1"><strong>@lang('projects.project'):</strong> {{ $exam->project->name }}</p>
                                <p class="mb-0"><strong>@lang('exams.total_questions'):</strong> {{ $exam->questions->count() }} @lang('exams.questions')</p>
                            </div>

                            <!-- Assignment Form -->
                            <form action="{{ route('teacher.exams.assign.store', $exam->id) }}" method="POST">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="section_id">@lang('sections.section') <span class="text-danger">*</span></label>
                                            <select name="section_id" id="section_id" class="form-control select2" required>
                                                <option value="">@lang('site.choose') @lang('sections.section')</option>
                                                @foreach($sections as $section)
                                                    <option value="{{ $section->id }}" 
                                                            {{ old('section_id') == $section->id ? 'selected' : '' }}
                                                            data-students-count="{{ $section->students->count() }}">
                                                        {{ $section->name }} ({{ $section->students->count() }} @lang('students.students'))
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('section_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="alert alert-info">
                                            <h6><i data-feather="clock"></i> @lang('exams.exam_time_note')</h6>
                                            <p class="mb-0">@lang('exams.examiner_will_set_time')</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Examiner Selection -->
                                <div class="form-group">
                                    <label for="examiner_id">@lang('exams.select_examiner') <span class="text-danger">*</span></label>
                                    <select name="examiner_id" id="examiner_id" class="form-control select2" required>
                                        <option value="">@lang('exams.choose_examiner')</option>
                                        @if($examiners->count() > 0)
                                            @foreach($examiners as $examiner)
                                                <option value="{{ $examiner->id }}" {{ old('examiner_id') == $examiner->id ? 'selected' : '' }}>
                                                    {{ $examiner->full_name }}
                                                </option>
                                            @endforeach
                                        @else
                                            <option disabled>Không có giám khảo nào</option>
                                        @endif
                                    </select>
                                    <small class="form-text text-muted">
                                        @if($examiners->count() > 0)
                                            @lang('exams.examiner_can_modify_time') ({{ $examiners->count() }} giám khảo khả dụng)
                                        @else
                                            <span class="text-danger">Không có giám khảo nào trong hệ thống</span>
                                        @endif
                                    </small>
                                    @error('examiner_id')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="notes">@lang('exams.notes')</label>
                                    <textarea name="notes" 
                                              id="notes" 
                                              class="form-control" 
                                              rows="3" 
                                              placeholder="@lang('exams.notes_placeholder')"
                                              maxlength="500">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <span id="notes-count">{{ strlen(old('notes', '')) }}</span>/500 @lang('site.characters')
                                    </small>
                                </div>

                                <!-- Student Count Info -->
                                <div class="alert alert-warning" id="students-info" style="display: none;">
                                    <h6><i data-feather="users"></i> @lang('exams.assignment_info')</h6>
                                    <p class="mb-0">@lang('exams.will_assign_to') <span id="students-count">0</span> @lang('students.students')</p>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <i data-feather="check"></i> @lang('exams.assign_exam')
                                    </button>
                                    <a href="{{ route('teacher.exams.index') }}" class="btn btn-secondary">
                                        <i data-feather="x"></i> @lang('site.cancel')
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Sidebar with instructions -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i data-feather="help-circle"></i>
                                @lang('site.instructions')
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h6><i data-feather="info"></i> @lang('exams.how_to_assign')</h6>
                                <ul class="mb-0">
                                    <li>@lang('exams.instruction_1')</li>
                                    <li>@lang('exams.instruction_2')</li>
                                    <li>@lang('exams.instruction_3')</li>
                                    <li>@lang('exams.instruction_4')</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize select2
    $('.select2').select2();

    // Update students count when section changes
    $('#section_id').on('change', function() {
        var studentsCount = $(this).find('option:selected').data('students-count');
        if (studentsCount > 0) {
            $('#students-count').text(studentsCount);
            $('#students-info').show();
        } else {
            $('#students-info').hide();
        }
    });

    // Character count for notes
    $('#notes').on('input', function() {
        var length = $(this).val().length;
        $('#notes-count').text(length);
        
        if (length > 450) {
            $('#notes-count').addClass('text-warning');
        } else {
            $('#notes-count').removeClass('text-warning');
        }
    });

    // Removed date_time field as examiner will set the time

    // Trigger change event on page load if section is selected
    if ($('#section_id').val()) {
        $('#section_id').trigger('change');
    }
});
</script>
@endpush 