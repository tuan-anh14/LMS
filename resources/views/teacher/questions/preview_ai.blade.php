@extends('layouts.teacher.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">
            <i class="fas fa-robot text-success mr-2"></i>
            Câu hỏi AI - {{ $exam->name }}
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
              <li class="breadcrumb-item"><a href="{{ route('teacher.exams.index') }}">@lang('exams.exams')</a></li>
              <li class="breadcrumb-item"><a href="{{ route('teacher.exams.questions.index', $exam->id) }}">@lang('questions.questions')</a></li>
              <li class="breadcrumb-item active">Câu hỏi AI</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content-body">
    <!-- Success Info -->
    <div class="row mb-3">
      <div class="col-12">
        <div class="alert alert-success border-l-success">
          <div class="d-flex align-items-center">
            <div class="alert-icon mr-3">
              <i class="fas fa-check-circle fa-2x text-success"></i>
            </div>
            <div class="flex-grow-1 p-2">
              <p class="mb-1">
                Tạo thành công {{ count($questions) }} câu hỏi!
              </p>
              <p class="mb-0">Hãy chọn những câu hỏi phù hợp để thêm vào bài kiểm tra. Click vào checkbox để chọn/bỏ chọn câu hỏi.</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <form method="POST" action="{{ route('teacher.exams.questions.save_ai', $exam->id) }}" id="previewForm">
      @csrf

      <!-- Control Panel -->
      <div class="row mb-4">
        <div class="col-12">
          <div class="card border-0 shadow-sm">
            <div class="card-body bg-light">
              <div class="row align-items-center">
                <div class="col-md-8">
                  <div class="selection-info">
                    <h6 class="mb-1">
                      <i class="fas fa-check-circle text-success mr-2"></i>
                      Đã chọn: <span id="selectedCount" class="badge badge-success badge-lg">{{ count($questions) }}</span>
                      / {{ count($questions) }} câu hỏi
                    </h6>
                    <small class="text-muted">
                      <i class="fas fa-info-circle mr-1"></i>
                      Click vào từng câu hỏi để chọn/bỏ chọn
                    </small>
                  </div>
                </div>
                <div class="col-md-4 text-right">
                  <button type="submit" class="btn btn-success btn-lg" id="saveBtn">
                    <i class="fas fa-save mr-2"></i>
                    Lưu câu hỏi đã chọn
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Questions List -->
      <div class="row">
        <div class="col-12">
          @if(!empty($questions))
          <div class="questions-list">
            @foreach($questions as $index => $question)
            @php
            $isMultipleChoice = $question['type'] === 'multiple_choice';
            $cardClass = $isMultipleChoice ? 'multiple-choice' : 'essay';
            $headerBg = $isMultipleChoice ? 'bg-warning' : 'bg-warning';
            $icon = $isMultipleChoice ? 'check-circle' : 'edit';
            $typeName = $isMultipleChoice ? 'Trắc nghiệm' : 'Tự luận';
            @endphp

            <div class="question-item mb-4" data-index="{{ $index }}">
              <div class="card question-card {{ $cardClass }} shadow-sm border-0">
                <!-- Question Header -->
                <div class="card-header {{ $headerBg }} text-white">
                  <div class="row align-items-center">
                    <div class="col-md-8">
                      <div class="d-flex align-items-center">
                        <div class="custom-control custom-checkbox mr-3">
                          <input type="checkbox" class="custom-control-input question-checkbox"
                            id="question_{{ $index }}" name="selected_questions[]" value="{{ $index }}" checked>
                          <label class="custom-control-label checkbox-white" for="question_{{ $index }}"></label>
                        </div>
                        <div class="question-info">
                          <h5 class="mb-1">
                            <i class="fas fa-{{ $icon }} mr-2"></i>
                            Câu {{ $index + 1 }}: {{ $typeName }}
                          </h5>
                          <div class="question-meta">
                            <span class="badge badge-success mr-2">
                              <i class="fas fa-star mr-1"></i>{{ $question['points'] ?? 1 }} điểm
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4 text-right">
                      <span class="badge">
                        <i class="fas fa-robot mr-1"></i>AI Generated
                      </span>
                    </div>
                  </div>
                </div>

                <!-- Question Content -->
                <div class="card-body">
                  <!-- Question Text -->
                  <div class="question-content mb-4">
                    <div class="content-label mb-2 mt-2">
                      <i class="fas fa-question-circle text-info mr-2"></i>
                      <strong>Nội dung câu hỏi:</strong>
                    </div>
                    <div class="question-text bg-light p-3 border-left-info">
                      <p class="mb-0 lead">{{ $question['content'] }}</p>
                    </div>
                  </div>

                  @if($isMultipleChoice && isset($question['options']))
                  <!-- Multiple Choice Options -->
                  <div class="options-section">
                    <div class="content-label mb-3">
                      <i class="fas fa-list text-primary mr-2"></i>
                      <strong>Các lựa chọn:</strong>
                    </div>
                    <div class="options-grid">
                      @foreach($question['options'] as $optionIndex => $option)
                      @php
                      $isCorrect = isset($question['correct_answer']) && $question['correct_answer'] === chr(65 + $optionIndex);
                      $optionClass = $isCorrect ? 'correct-option' : 'normal-option';
                      @endphp
                      <div class="option-item {{ $optionClass }} mb-2">
                        <div class="d-flex align-items-center p-3 border rounded">
                          <div class="option-letter {{ $isCorrect ? 'correct' : '' }}">
                            {{ chr(65 + $optionIndex) }}
                          </div>
                          <div class="option-text ml-3 flex-grow-1">
                            {{ $option }}
                          </div>
                          @if($isCorrect)
                          <div class="correct-mark">
                            <i class="fas fa-check-circle text-success fa-lg"></i>
                            <span class="ml-1 text-success font-weight-bold">Đúng</span>
                          </div>
                          @endif
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                  @elseif(!$isMultipleChoice)
                  <!-- Essay Answer Guide -->
                  @if(isset($question['correct_answer']) && !empty($question['correct_answer']))
                  <div class="essay-section">
                    <div class="content-label mb-2">
                      <i class="fas fa-lightbulb text-warning mr-2"></i>
                      <strong>Gợi ý đáp án:</strong>
                    </div>
                    <div class="essay-guide bg-light-warning p-3 border-left-warning">
                      <p class="mb-0">{{ $question['correct_answer'] }}</p>
                    </div>
                  </div>
                  @endif
                  @endif
                </div>
              </div>
            </div>
            @endforeach
          </div>
          @else
          <!-- Empty State -->
          <div class="text-center py-5">
            <div class="empty-state">
              <i class="fas fa-question-circle fa-4x text-muted mb-3"></i>
              <h4 class="text-muted mb-2">Không có câu hỏi nào được tạo</h4>
              <p class="text-muted mb-4">Hãy thử tạo lại với chủ đề hoặc yêu cầu khác</p>
              <a href="{{ route('teacher.exams.questions.create_ai', $exam->id) }}" class="btn btn-primary">
                <i class="fas fa-redo mr-2"></i> Tạo lại câu hỏi
              </a>
            </div>
          </div>
          @endif
        </div>
      </div>

      @if(!empty($questions))
      <!-- Bottom Actions -->
      <div class="row mt-4">
        <div class="col-12">
          <div class="card bg-light border-0">
            <div class="card-body text-center">
              <div class="row align-items-center">
                <div class="col-md-4">
                  <div class="summary-info">
                    <h6 class="mb-0">
                      <i class="fas fa-info-circle text-info mr-2"></i>
                      <span id="selectedCountBottom">{{ count($questions) }}</span> câu hỏi đã được chọn
                    </h6>
                  </div>
                </div>
                <div class="col-md-8">
                  <div class="action-buttons">
                    <button type="submit" class="btn btn-success btn-lg mr-3" id="saveBtnBottom">
                      <i class="fas fa-save mr-2"></i>
                      Lưu vào bài kiểm tra
                    </button>
                    <a href="{{ route('teacher.exams.questions.create_ai', $exam->id) }}" class="btn btn-warning mr-2">
                      <i class="fas fa-redo mr-2"></i> Tạo lại
                    </a>
                    <a href="{{ route('teacher.exams.questions.index', $exam->id) }}" class="btn btn-secondary">
                      <i class="fas fa-times mr-2"></i> Hủy bỏ
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endif
    </form>
  </div>
</div>
@endsection

@section('scripts')
<style>
  /* Simple and Clear UI Styles */

  /* Color coding for question types */
  .question-card.multiple-choice {
    border-left: 5px solid #007bff;
  }

  .question-card.multiple-choice.selected {
    border-left: 5px solid #28a745;
  }

  .question-card.essay {
    border-left: 5px solid #ffc107;
  }

  .question-card.essay.selected {
    border-left: 5px solid #28a745;
  }

  /* Checkbox container highlighting */
  .question-item.selected .custom-control {
    background: rgba(40, 167, 69, 0.1);
    border-radius: 8px;
    padding: 5px;
  }

  /* Visual feedback for clickable areas */
  .question-card {
    position: relative;
  }

  .question-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: transparent;
    border-radius: inherit;
    transition: all 0.3s ease;
    pointer-events: none;
  }

  .question-card:hover::before {
    background: rgba(0, 123, 255, 0.05);
  }

  .question-item.selected .question-card::before {
    background: rgba(40, 167, 69, 0.08);
  }

  .border-l-success {
    border-left: 4px solid #28a745;
  }

  .border-left-info {
    border-left: 4px solid #17a2b8;
  }

  .border-left-warning {
    border-left: 4px solid #ffc107;
  }

  /* Question cards */
  .question-item {
    transition: all 0.3s ease;
  }

  .question-item:hover {
    transform: translateY(-2px);
  }

  .question-card {
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .question-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  }

  .question-item.selected .question-card {
    box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
    border-color: #28a745;
    background: linear-gradient(145deg, #ffffff 0%, #f8fff9 100%);
  }

  .question-item.selected .question-card .card-header {
    border-bottom: 2px solid rgba(40, 167, 69, 0.2);
  }

  /* Enhanced checkbox styling for better visibility */
  .checkbox-white .custom-control-label::before {
    background-color: #ffffff;
    border: 3px solid #6c757d;
    width: 24px;
    height: 24px;
    border-radius: 6px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  .checkbox-white .custom-control-label::after {
    width: 24px;
    height: 24px;
    top: 0;
    left: 0;
    font-size: 16px;
    line-height: 1.5;
  }

  /* Unchecked state - clearly visible gray border */
  .checkbox-white .custom-control-input:not(:checked)~.custom-control-label::before {
    background-color: #ffffff;
    border-color: #6c757d;
  }

  /* Checked state - bright success green */
  .checkbox-white .custom-control-input:checked~.custom-control-label::before {
    background-color: #28a745;
    border-color: #28a745;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.4);
    transform: scale(1.05);
  }

  .checkbox-white .custom-control-input:checked~.custom-control-label::after {
    color: #ffffff;
    font-size: 16px;
    font-weight: bold;
  }

  /* Hover effects for better UX */
  .question-card:hover .checkbox-white .custom-control-label::before {
    border-color: #007bff;
    box-shadow: 0 2px 6px rgba(0, 123, 255, 0.3);
    transform: scale(1.02);
  }

  .question-card:hover .checkbox-white .custom-control-input:checked~.custom-control-label::before {
    border-color: #28a745;
    box-shadow: 0 2px 10px rgba(40, 167, 69, 0.5);
    transform: scale(1.07);
  }

  /* Focus states for accessibility */
  .checkbox-white .custom-control-input:focus~.custom-control-label::before {
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
    border-color: #007bff;
  }

  .checkbox-white .custom-control-input:focus:checked~.custom-control-label::before {
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.25);
  }

  /* Additional visual feedback for selected questions */
  .question-item.selected .checkbox-white .custom-control-label::before {
    border-width: 4px;
    box-shadow: 0 3px 12px rgba(40, 167, 69, 0.6);
  }

  /* Content areas */
  .content-label {
    font-size: 1rem;
    color: #495057;
  }

  .question-text {
    border-radius: 8px;
  }

  .bg-light-warning {
    background-color: #fff3cd;
  }

  /* Option styling */
  .option-item {
    transition: all 0.2s ease;
  }

  .option-item:hover {
    transform: translateX(5px);
  }

  .normal-option {
    border-color: #dee2e6;
  }

  .correct-option {
    background-color: #d4edda;
    border-color: #28a745 !important;
  }

  .option-letter {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background-color: #f8f9fa;
    border: 2px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    color: #495057;
  }

  .option-letter.correct {
    background-color: #28a745;
    border-color: #28a745;
    color: white;
  }

  /* Selection counter */
  .badge-lg {
    font-size: 1rem;
    padding: 0.5rem 0.75rem;
  }

  /* Alert styling */
  .alert-icon {
    flex-shrink: 0;
  }

  /* Buttons */
  .btn-lg {
    font-size: 1.1rem;
    padding: 0.75rem 1.5rem;
  }

  /* Animation for entrance */
  .question-item {
    animation: slideInUp 0.5s ease-out;
  }

  @keyframes slideInUp {
    from {
      opacity: 0;
      transform: translateY(20px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Animate.css compatible animations */
  .animate__animated {
    animation-duration: 0.6s;
    animation-fill-mode: both;
  }

  .animate__pulse {
    animation-name: pulse;
  }

  @keyframes pulse {
    from {
      transform: scale3d(1, 1, 1);
    }

    50% {
      transform: scale3d(1.05, 1.05, 1.05);
    }

    to {
      transform: scale3d(1, 1, 1);
    }
  }

  /* Button state transitions */
  .btn {
    transition: all 0.3s ease;
  }

  .btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
  }

  /* Keyboard shortcut styling */
  kbd {
    display: inline-block;
    padding: 0.1875rem 0.375rem;
    font-size: 0.75rem;
    color: #495057;
    background-color: #f8f9fa;
    border-radius: 0.25rem;
    box-shadow: inset 0 -0.1rem 0 rgba(0, 0, 0, 0.25);
    font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
  }

  /* Enhanced visual feedback */
  .question-item.selected {
    transition: all 0.3s ease;
  }

  .question-item.selected .question-card {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.25);
  }

  /* Loading overlay for form */
  #previewForm.loading {
    position: relative;
    pointer-events: none;
  }

  #previewForm.loading::before {
    content: '';
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.8);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  #previewForm.loading::after {
    content: '';
    position: fixed;
    top: 50%;
    left: 50%;
    width: 40px;
    height: 40px;
    margin: -20px 0 0 -20px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    z-index: 10000;
  }

  @keyframes spin {
    0% {
      transform: rotate(0deg);
    }

    100% {
      transform: rotate(360deg);
    }
  }

  /* Loading state */
  .loading {
    opacity: 0.6;
    pointer-events: none;
  }

  /* Responsive */
  @media (max-width: 768px) {
    .control-panel .row>div {
      margin-bottom: 1rem;
    }

    .action-buttons .btn {
      display: block;
      width: 100%;
      margin-bottom: 0.5rem;
    }
  }
</style>

<script>
  $(document).ready(function() {
    // Update selection count and styling
    function updateSelection() {
      var checkedCount = $('.question-checkbox:checked').length;
      var totalCount = $('.question-checkbox').length;

      // Update counters
      $('#selectedCount').text(checkedCount);
      $('#selectedCountBottom').text(checkedCount);

      // Update save button state
      if (checkedCount > 0) {
        $('#saveBtn, #saveBtnBottom').prop('disabled', false)
          .removeClass('btn-secondary').addClass('btn-success');
      } else {
        $('#saveBtn, #saveBtnBottom').prop('disabled', true)
          .removeClass('btn-success').addClass('btn-secondary');
      }

      // Update question item styling
      $('.question-checkbox').each(function() {
        var questionItem = $(this).closest('.question-item');
        var questionCard = questionItem.find('.question-card');
        if ($(this).is(':checked')) {
          questionItem.addClass('selected');
          questionCard.addClass('selected');
        } else {
          questionItem.removeClass('selected');
          questionCard.removeClass('selected');
        }
      });

      // Update selection info text
      var selectionText = '';
      if (checkedCount === 0) {
        selectionText = 'Chưa chọn câu hỏi nào';
      } else if (checkedCount === totalCount) {
        selectionText = 'Đã chọn tất cả ' + totalCount + ' câu hỏi';
      } else {
        selectionText = 'Đã chọn ' + checkedCount + '/' + totalCount + ' câu hỏi';
      }
      $('.selection-info small').text(selectionText);
    }

    // Handle checkbox changes
    $('.question-checkbox').on('change', function() {
      updateSelection();

      // Add visual feedback
      var questionItem = $(this).closest('.question-item');
      if ($(this).is(':checked')) {
        questionItem.addClass('animate__animated animate__pulse');
        setTimeout(function() {
          questionItem.removeClass('animate__animated animate__pulse');
        }, 600);
      }
    });

    // Handle form submission validation
    $('#previewForm').on('submit', function(e) {
      var checkedCount = $('.question-checkbox:checked').length;

      if (checkedCount === 0) {
        e.preventDefault();
        alert('Vui lòng chọn ít nhất một câu hỏi để lưu vào bài kiểm tra!');
        return false;
      }

      // Show confirmation
      if (!confirm('Bạn đang lưu ' + checkedCount + ' câu hỏi vào bài kiểm tra. Tiếp tục?')) {
        e.preventDefault();
        return false;
      }

      // Show loading state
      $('#saveBtn, #saveBtnBottom').prop('disabled', true)
        .html('<i class="fas fa-spinner fa-spin mr-2"></i>Đang lưu...');
    });

    // Click on question card to toggle checkbox
    $('.question-card').on('click', function(e) {
      // Avoid triggering when clicking on checkboxes, buttons, links, etc.
      if (!$(e.target).closest('.custom-control, .btn, a, .badge').length) {
        var checkbox = $(this).find('.question-checkbox');
        var isChecked = checkbox.is(':checked');
        checkbox.prop('checked', !isChecked).trigger('change');
      }
    });

    // Initial update
    updateSelection();
  });
</script>
@endsection