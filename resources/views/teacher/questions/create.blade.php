@extends('layouts.teacher.app')

@section('content')
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-9 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-left mb-0">@lang('questions.create_question') - {{ $exam->name }}</h2>
                        <div class="breadcrumb-wrapper">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teacher.exams.index') }}">@lang('exams.exams')</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('teacher.exams.questions.index', $exam->id) }}">@lang('questions.questions')</a></li>
                                <li class="breadcrumb-item active">@lang('site.create')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" action="{{ route('teacher.exams.questions.store', $exam->id) }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Loại câu hỏi <span class="text-danger">*</span></label>
                                            <select name="type" id="question_type" class="form-control" required>
                                                <option value="">Chọn loại câu hỏi</option>
                                                @foreach($questionTypes as $value => $label)
                                                    <option value="{{ $value }}">{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Điểm số <span class="text-danger">*</span></label>
                                            <input type="number" name="points" class="form-control" min="0.1" step="0.1" value="1.0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>@lang('questions.content') <span class="text-danger">*</span></label>
                                    <textarea name="content" class="form-control" rows="3" required placeholder="Nhập nội dung câu hỏi..."></textarea>
                                </div>

                                <!-- Multiple Choice Options -->
                                <div id="multiple_choice_section" style="display: none;">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Các đáp án trắc nghiệm <span class="text-danger">*</span></label>
                                        <div id="options_container">
                                            <!-- Default A and B options -->
                                            <div class="card mb-2 option-card">
                                                <div class="card-body py-2">
                                                    <div class="d-flex align-items-center">
                                                        <span class="option-letter bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" 
                                                              style="width: 35px; height: 35px; font-weight: bold;">A</span>
                                                        <input type="text" name="options[]" class="form-control option-input" placeholder="Nhập nội dung đáp án A">
                                                        <div class="ml-2">
                                                            <button type="button" class="btn btn-sm btn-success add-option">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mb-2 option-card">
                                                <div class="card-body py-2">
                                                    <div class="d-flex align-items-center">
                                                        <span class="option-letter bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" 
                                                              style="width: 35px; height: 35px; font-weight: bold;">B</span>
                                                        <input type="text" name="options[]" class="form-control option-input" placeholder="Nhập nội dung đáp án B">
                                                        <div class="ml-2">
                                                            <button type="button" class="btn btn-sm btn-danger remove-option">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa fa-info-circle"></i> 
                                            Cần ít nhất 2 đáp án. Sử dụng nút + để thêm đáp án, nút - để xóa đáp án.
                                        </small>
                                    </div>
                                    
                                    <!-- Correct Answer Selection -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Chọn đáp án đúng <span class="text-danger">*</span></label>
                                        <div id="correct_answer_options" class="row">
                                            <!-- Dynamic correct answer options will be generated here -->
                                        </div>
                                        <small class="text-muted">
                                            <i class="fa fa-check-circle"></i> 
                                            Chọn đáp án đúng từ các tùy chọn bên trên
                                        </small>
                                    </div>
                                </div>

                                <!-- Essay Answer Template -->
                                <div id="essay_section" style="display: none;">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Đáp án mẫu cho câu tự luận</label>
                                        <textarea name="correct_answer" class="form-control essay-answer" rows="4" placeholder="Nhập đáp án mẫu hoặc hướng dẫn chấm điểm cho câu tự luận..."></textarea>
                                        <small class="text-muted">
                                            <i class="fa fa-lightbulb"></i> 
                                            Đáp án mẫu sẽ giúp examiner chấm điểm chính xác và nhất quán hơn
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i data-feather="plus"></i> @lang('site.create')
                                    </button>
                                    <a href="{{ route('teacher.exams.questions.index', $exam->id) }}" class="btn btn-secondary btn-lg">
                                        <i data-feather="x"></i> @lang('site.cancel')
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<style>
.option-card {
    border-left: 4px solid #007bff;
    transition: all 0.3s ease;
}

.option-card:hover {
    box-shadow: 0 2px 8px rgba(0,123,255,0.2);
}

.correct-answer-option {
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
}

.correct-answer-option:hover {
    border-color: #007bff;
    transform: translateY(-2px);
}

.correct-answer-option.selected {
    border-color: #28a745;
    background-color: #f8fff9;
}

.correct-answer-option input[type="radio"] {
    transform: scale(1.2);
}

.cursor-pointer {
    cursor: pointer;
}
</style>

<script>
$(document).ready(function() {
    console.log('Create form ready');
    
    // Handle question type change
    $('#question_type').change(function() {
        var type = $(this).val();
        console.log('Question type changed to:', type);
        
        if (type === 'multiple_choice') {
            $('#multiple_choice_section').show();
            $('#essay_section').hide();
            
            // Add required attribute to option inputs
            $('.option-input').attr('required', true);
            $('.essay-answer').removeAttr('required');
            
            updateCorrectAnswerOptions();
            updateOptionLabels();
        } else if (type === 'essay') {
            $('#multiple_choice_section').hide();
            $('#essay_section').show();
            
            // Remove required from option inputs and add to essay
            $('.option-input').removeAttr('required');
            $('.essay-answer').attr('required', true);
        } else {
            $('#multiple_choice_section').hide();
            $('#essay_section').hide();
            
            // Remove all required attributes
            $('.option-input').removeAttr('required');
            $('.essay-answer').removeAttr('required');
        }
    });

    // Add option
    $(document).on('click', '.add-option', function() {
        var currentCount = $('#options_container .option-card').length;
        if (currentCount >= 6) {
            alert('Tối đa chỉ được 6 đáp án!');
            return;
        }
        
        var nextLetter = String.fromCharCode(65 + currentCount);
        var isRequired = $('#question_type').val() === 'multiple_choice' ? 'required' : '';
        
        var newOption = `
            <div class="card mb-2 option-card">
                <div class="card-body py-2">
                    <div class="d-flex align-items-center">
                        <span class="option-letter bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mr-3" 
                              style="width: 35px; height: 35px; font-weight: bold;">${nextLetter}</span>
                        <input type="text" name="options[]" class="form-control option-input" placeholder="Nhập nội dung đáp án ${nextLetter}" ${isRequired}>
                        <div class="ml-2">
                            <button type="button" class="btn btn-sm btn-danger remove-option">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('#options_container').append(newOption);
        updateOptionLabels();
        updateCorrectAnswerOptions();
    });

    // Remove option
    $(document).on('click', '.remove-option', function() {
        if ($('#options_container .option-card').length > 2) {
            $(this).closest('.option-card').remove();
            updateOptionLabels();
            updateCorrectAnswerOptions();
        } else {
            alert('Cần ít nhất 2 đáp án cho câu hỏi trắc nghiệm!');
        }
    });

    // Update options when text changes
    $(document).on('input', 'input[name="options[]"]', function() {
        updateCorrectAnswerOptions();
    });

    // Handle correct answer selection
    $(document).on('click', '.correct-answer-option', function() {
        $('.correct-answer-option').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);
    });

    // Form validation before submit
    $('form').on('submit', function(e) {
        var questionType = $('#question_type').val();
        
        if (!questionType) {
            e.preventDefault();
            alert('Vui lòng chọn loại câu hỏi!');
            return false;
        }
        
        if (questionType === 'multiple_choice') {
            // Check if at least 2 options are filled
            var filledOptions = 0;
            $('.option-input').each(function() {
                if ($(this).val().trim() !== '') {
                    filledOptions++;
                }
            });
            
            if (filledOptions < 2) {
                e.preventDefault();
                alert('Cần ít nhất 2 đáp án cho câu hỏi trắc nghiệm!');
                return false;
            }
            
            // Check if correct answer is selected
            if (!$('input[name="correct_answer"]:checked').length) {
                e.preventDefault();
                alert('Vui lòng chọn đáp án đúng!');
                return false;
            }
        }
        
        return true;
    });

    function updateOptionLabels() {
        $('#options_container .option-card').each(function(index) {
            var letter = String.fromCharCode(65 + index);
            $(this).find('.option-letter').text(letter);
            $(this).find('input[name="options[]"]').attr('placeholder', 'Nhập nội dung đáp án ' + letter);
        });
    }

    function updateCorrectAnswerOptions() {
        var container = $('#correct_answer_options');
        container.empty();
        
        $('#options_container input[name="options[]"]').each(function(index) {
            var letter = String.fromCharCode(65 + index);
            var value = $(this).val();
            var displayText = value.trim() !== '' ? value : `Đáp án ${letter}`;
            
            var optionHtml = `
                <div class="col-md-6 mb-2">
                    <div class="correct-answer-option p-3 rounded">
                        <label class="mb-0 w-100 cursor-pointer">
                            <input type="radio" name="correct_answer" value="${letter}" class="mr-2">
                            <span class="option-letter-small bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mr-2" 
                                  style="width: 25px; height: 25px; font-size: 12px; font-weight: bold;">${letter}</span>
                            <span class="option-text">${displayText}</span>
                        </label>
                    </div>
                </div>
            `;
            container.append(optionHtml);
        });
    }

    // Initialize on page load
    var initialType = $('#question_type').val();
    if (initialType === 'multiple_choice') {
        $('#multiple_choice_section').show();
        updateOptionLabels();
        updateCorrectAnswerOptions();
    }
});
</script>
@endsection 