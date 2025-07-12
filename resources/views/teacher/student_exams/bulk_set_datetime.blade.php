@extends('layouts.teacher.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('student_exams.bulk_set_datetime')</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teacher.student_exams.index') }}">@lang('student_exams.student_exams')</a></li>
                                <li class="breadcrumb-item active">@lang('student_exams.bulk_set_datetime')</li>
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
                                <i data-feather="clock"></i>
                                @lang('student_exams.bulk_set_datetime')
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

                            @if($assignmentGroups->isEmpty())
                                <div class="alert alert-info">
                                    <h5><i data-feather="info"></i> @lang('student_exams.no_assignments')</h5>
                                    <p class="mb-0">@lang('student_exams.no_pending_assignments')</p>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <h6><i data-feather="users"></i> @lang('student_exams.assignments_info')</h6>
                                    <p class="mb-0">@lang('student_exams.select_exam_section_and_time')</p>
                                </div>

                                <form action="{{ route('teacher.student_exams.bulk_set_datetime.store') }}" method="POST">
                                    @csrf
                                    
                                    <div class="form-group">
                                        <label for="assignment_group">@lang('student_exams.select_assignment_group') <span class="text-danger">*</span></label>
                                        <select name="assignment_group" id="assignment_group" class="form-control" required>
                                            <option value="">@lang('site.choose') @lang('student_exams.assignment_group')</option>
                                            @foreach($assignmentGroups as $key => $group)
                                                <option value="{{ $key }}" 
                                                        data-exam-id="{{ $group['exam_id'] }}" 
                                                        data-section-id="{{ $group['section_id'] }}"
                                                        data-count="{{ $group['count'] }}">
                                                    {{ $group['project']->name }} - {{ $group['exam']->name }} - {{ $group['section']->name }} ({{ $group['count'] }} @lang('students.students'))
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('assignment_group')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <input type="hidden" name="exam_id" id="exam_id" value="{{ old('exam_id') }}">
                                    <input type="hidden" name="section_id" id="section_id" value="{{ old('section_id') }}">

                                    <div class="form-group">
                                        <label for="date_time">@lang('student_exams.exam_date_time') <span class="text-danger">*</span></label>
                                        <input type="datetime-local" 
                                               name="date_time" 
                                               id="date_time" 
                                               class="form-control" 
                                               value="{{ old('date_time') }}" 
                                               min="{{ date('Y-m-d\TH:i') }}"
                                               required>
                                        @error('date_time')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Student Count Info -->
                                    <div class="alert alert-warning" id="students-info" style="display: none;">
                                        <h6><i data-feather="users"></i> @lang('student_exams.assignment_info')</h6>
                                        <p class="mb-0">@lang('student_exams.will_set_time_for') <span id="students-count">0</span> @lang('students.students')</p>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i data-feather="check"></i> @lang('student_exams.set_datetime')
                                        </button>
                                        <a href="{{ route('teacher.student_exams.index') }}" class="btn btn-secondary">
                                            <i data-feather="x"></i> @lang('site.cancel')
                                        </a>
                                    </div>
                                </form>
                            @endif
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
                                <h6><i data-feather="info"></i> @lang('student_exams.how_to_bulk_set')</h6>
                                <ul class="mb-0">
                                    <li>@lang('student_exams.instruction_1')</li>
                                    <li>@lang('student_exams.instruction_2')</li>
                                    <li>@lang('student_exams.instruction_3')</li>
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
    // Update hidden fields and student count when assignment group changes
    $('#assignment_group').on('change', function() {
        var selectedOption = $(this).find('option:selected');
        var examId = selectedOption.data('exam-id');
        var sectionId = selectedOption.data('section-id');
        var count = selectedOption.data('count');
        
        $('#exam_id').val(examId);
        $('#section_id').val(sectionId);
        
        if (count > 0) {
            $('#students-count').text(count);
            $('#students-info').show();
        } else {
            $('#students-info').hide();
        }
    });

    // Set minimum date to current date/time
    var now = new Date();
    var minDateTime = now.toISOString().slice(0, 16);
    $('#date_time').attr('min', minDateTime);

    // Trigger change event on page load if option is selected
    if ($('#assignment_group').val()) {
        $('#assignment_group').trigger('change');
    }
});
</script>
@endpush 