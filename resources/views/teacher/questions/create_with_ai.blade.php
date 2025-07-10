@extends('layouts.teacher.app')

@section('content')
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-9 col-12 mb-2">
      <div class="row breadcrumbs-top">
        <div class="col-12">
          <h2 class="content-header-title float-left mb-0">
            <i class="fas fa-robot text-gradient-primary mr-2"></i>
            Tạo câu hỏi bằng AI - {{ $exam->name }}
          </h2>
          <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('teacher.home') }}">@lang('site.home')</a></li>
              <li class="breadcrumb-item"><a href="{{ route('teacher.exams.index') }}">@lang('exams.exams')</a></li>
              <li class="breadcrumb-item"><a href="{{ route('teacher.exams.questions.index', $exam->id) }}">@lang('questions.questions')</a></li>
              <li class="breadcrumb-item active">Tạo câu hỏi AI</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="content-body">
    <!-- Information Alert -->
    <div class="row">
      <div class="col-12">
        <div class="alert alert-primary alert-dismissible mb-2" role="alert">
          <p class="mb-0 p-2">
            Sử dụng GPT-4o-mini để tạo câu hỏi chất lượng cao dựa trên chủ đề bạn cung cấp.
            <span class="badge badge-light-primary">Tối đa {{ config('services.openai.max_questions', 10) }} câu hỏi</span> mỗi lần tạo.
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-8 offset-md-2">
      <div class="card card-congratulations">
        <div class="card-header bg-gradient-primary">
          <h4 class="card-title text-white mb-0">
            <i class="fas fa-cogs mr-2"></i>
            Cấu hình tạo câu hỏi
          </h4>
        </div>
        <div class="card-body card-congratulations-img">
          <form method="POST" action="{{ route('teacher.exams.questions.generate_ai', $exam->id) }}" id="aiGenerationForm">
            @csrf

            <!-- Topic Section -->
            <div class="card border-left-primary shadow-sm mb-3">
              <div class="card-body">
                <div class="form-group mb-0">
                  <label class="form-label font-weight-bold text-primary">
                    <i class="fas fa-book-open mr-1"></i>
                    Chủ đề câu hỏi <span class="text-danger">*</span>
                  </label>
                  <textarea name="topic" class="form-control form-control-lg @error('topic') is-invalid @enderror"
                    rows="3" required
                    placeholder="Ví dụ: Phương trình bậc hai, Lịch sử Việt Nam thế kỷ 20, Ngữ pháp tiếng Anh cơ bản...">{{ old('topic') }}</textarea>
                  @error('topic')
                  <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                  <small class="text-muted">
                    <i class="fas fa-lightbulb text-warning"></i>
                    Mô tả chi tiết chủ đề để AI tạo ra những câu hỏi phù hợp và chất lượng
                  </small>
                </div>
              </div>
            </div>

            <!-- Configuration Section -->
            <div class="card border-left-info shadow-sm mb-3">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label font-weight-bold text-info">
                        <i class="fas fa-list-ol mr-1"></i>
                        Số lượng câu hỏi <span class="text-danger">*</span>
                      </label>
                      <select name="count" class="form-control form-control-lg select2 @error('count') is-invalid @enderror" required>
                        <option value="">Chọn số lượng</option>
                        @for($i = 1; $i <= config('services.openai.max_questions', 10); $i++)
                          <option value="{{ $i }}" {{ old('count') == $i ? 'selected' : '' }}>
                          {{ $i }} câu hỏi
                          </option>
                          @endfor
                      </select>
                      @error('count')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="form-label font-weight-bold text-warning">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Độ khó <span class="text-danger">*</span>
                      </label>
                      <select name="difficulty" class="form-control form-control-lg select2 @error('difficulty') is-invalid @enderror" required>
                        <option value="">Chọn độ khó</option>
                        <option value="easy" {{ old('difficulty') == 'easy' ? 'selected' : '' }}>
                          🟢 Dễ (Cơ bản)
                        </option>
                        <option value="medium" {{ old('difficulty') == 'medium' ? 'selected' : '' }}>
                          🟡 Trung bình
                        </option>
                        <option value="hard" {{ old('difficulty') == 'hard' ? 'selected' : '' }}>
                          🔴 Khó (Nâng cao)
                        </option>
                      </select>
                      @error('difficulty')
                      <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Question Type Section -->
            <div class="card border-left-success shadow-sm mb-3">
              <div class="card-body">
                <label class="form-label font-weight-bold text-success mb-3">
                  <i class="fas fa-question-circle mr-1"></i>
                  Loại câu hỏi <span class="text-danger">*</span>
                </label>
                <div class="row">
                  <div class="col-md-4 mb-3">
                    <div class="question-type-card">
                      <div class="custom-control custom-radio custom-radio-primary">
                        <input type="radio" id="type_multiple" name="type" value="multiple_choice"
                          class="custom-control-input" {{ old('type') == 'multiple_choice' ? 'checked' : '' }} required>
                        <label for="type_multiple" class="custom-control-label w-100">
                          <div class="card border text-center h-100 question-type-label">
                            <div class="card-body">
                              <div class="avatar bg-light-primary p-50 mb-1 mx-auto">
                                <div class="avatar-content">
                                  <i class="fas fa-check-circle fa-2x text-primary"></i>
                                </div>
                              </div>
                              <h5 class="mb-1">Trắc nghiệm</h5>
                              <small class="text-muted">4 lựa chọn A, B, C, D</small>
                            </div>
                          </div>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="question-type-card">
                      <div class="custom-control custom-radio custom-radio-warning">
                        <input type="radio" id="type_essay" name="type" value="essay"
                          class="custom-control-input" {{ old('type') == 'essay' ? 'checked' : '' }} required>
                        <label for="type_essay" class="custom-control-label w-100">
                          <div class="card border text-center h-100 question-type-label">
                            <div class="card-body">
                              <div class="avatar bg-light-warning p-50 mb-1 mx-auto">
                                <div class="avatar-content">
                                  <i class="fas fa-edit fa-2x text-warning"></i>
                                </div>
                              </div>
                              <h5 class="mb-1">Tự luận</h5>
                              <small class="text-muted">Câu hỏi mở rộng</small>
                            </div>
                          </div>
                        </label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="question-type-card">
                      <div class="custom-control custom-radio custom-radio-info">
                        <input type="radio" id="type_mixed" name="type" value="mixed"
                          class="custom-control-input" {{ old('type', 'mixed') == 'mixed' ? 'checked' : '' }} required>
                        <label for="type_mixed" class="custom-control-label w-100">
                          <div class="card border text-center h-100 question-type-label">
                            <div class="card-body">
                              <div class="avatar bg-light-info p-50 mb-1 mx-auto">
                                <div class="avatar-content">
                                  <i class="fas fa-layer-group fa-2x text-info"></i>
                                </div>
                              </div>
                              <h5 class="mb-1">Kết hợp</h5>
                              <small class="text-muted">Cả trắc nghiệm và tự luận</small>
                            </div>
                          </div>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                @error('type')
                <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
              </div>
            </div>

            @if($errors->has('ai_error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
                <div>
                  <h6 class="alert-heading mb-1">Lỗi tạo câu hỏi</h6>
                  <span>{{ $errors->first('ai_error') }}</span>
                </div>
              </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="card border-left-secondary shadow-sm">
              <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="text-muted">
                    <i class="fas fa-info-circle mr-1"></i>
                    Nhấn tạo để AI bắt đầu sinh câu hỏi
                  </div>
                  <div>
                    <button type="submit" class="btn btn-gradient-primary btn-lg waves-effect waves-float waves-light" id="generateBtn">
                      <i class="fas fa-magic mr-2"></i>
                      Tạo câu hỏi bằng AI
                    </button>
                    <button type="button" class="btn btn-primary btn-lg waves-effect waves-float waves-light d-none" id="loadingBtn" disabled>
                      <i class="fas fa-spinner fa-spin mr-2"></i>
                      Đang tạo câu hỏi...
                    </button>
                  </div>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-center">
                  <a href="{{ route('teacher.exams.questions.index', $exam->id) }}" class="btn btn-outline-secondary mr-2">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Quay lại
                  </a>
                  <a href="{{ route('teacher.exams.questions.create', $exam->id) }}" class="btn btn-outline-info">
                    <i class="fas fa-plus mr-1"></i>
                    Tạo thủ công
                  </a>
                </div>
              </div>
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
  /* AI Form Styles */
  .border-left-primary {
    border-left: 4px solid #7367f0 !important;
  }

  .border-left-info {
    border-left: 4px solid #00cfe8 !important;
  }

  .border-left-success {
    border-left: 4px solid #28c76f !important;
  }

  .border-left-secondary {
    border-left: 4px solid #82868b !important;
  }

  .card-congratulations {
    background: linear-gradient(118deg, #7367f0, rgba(115, 103, 240, 0.7));
    background-color: #7367f0;
  }

  .card-congratulations .card-body {
    background: #fff;
    border-radius: 0.357rem;
  }

  .card-congratulations-img {
    position: relative;
  }

  .question-type-card .custom-control {
    width: 100%;
  }

  .question-type-card .custom-control-label {
    position: relative;
    cursor: pointer;
  }

  .question-type-card .custom-control-label::before,
  .question-type-card .custom-control-label::after {
    display: none;
  }

  .question-type-card .question-type-label {
    transition: all 0.3s ease;
    min-height: 140px;
    display: block;
    margin: 0;
  }

  .question-type-card .question-type-label:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 25px 0 rgba(34, 41, 47, 0.15);
  }

  .question-type-card .question-type-label:hover .card {
    border-color: #7367f0 !important;
  }

  .question-type-card .custom-control-input:checked+.custom-control-label .card {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px 0 rgba(115, 103, 240, 0.4);
    border-color: #7367f0 !important;
    background: linear-gradient(45deg, rgba(115, 103, 240, 0.1), rgba(255, 255, 255, 0.9));
  }

  .custom-radio-primary .custom-control-input:checked~.custom-control-label::before {
    background-color: #7367f0;
    border-color: #7367f0;
  }

  .custom-radio-warning .custom-control-input:checked~.custom-control-label::before {
    background-color: #ff9f43;
    border-color: #ff9f43;
  }

  .custom-radio-info .custom-control-input:checked~.custom-control-label::before {
    background-color: #00cfe8;
    border-color: #00cfe8;
  }

  .avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
  }

  .bg-gradient-primary {
    background: linear-gradient(118deg, #7367f0, rgba(115, 103, 240, 0.7)) !important;
  }

  .btn-gradient-primary {
    background: linear-gradient(45deg, #7367f0, #9c88ff);
    border: none;
    box-shadow: 0 4px 18px 0 rgba(115, 103, 240, 0.4);
  }

  .btn-gradient-primary:hover {
    background: linear-gradient(45deg, #5e50ee, #7367f0);
    box-shadow: 0 8px 25px 0 rgba(115, 103, 240, 0.6);
    transform: translateY(-2px);
  }

  .alert-primary {
    background: linear-gradient(90deg, rgba(115, 103, 240, 0.12), rgba(115, 103, 240, 0.05));
    border: 1px solid rgba(115, 103, 240, 0.3);
    border-left: 4px solid #7367f0;
  }

  .text-gradient-primary {
    background: linear-gradient(45deg, #7367f0, #9c88ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }

  .form-control:focus {
    border-color: #7367f0;
    box-shadow: 0 3px 10px 0 rgba(115, 103, 240, 0.2);
  }

  .select2-container--default .select2-selection--single:focus {
    border-color: #7367f0;
  }

  .waves-effect {
    position: relative;
    cursor: pointer;
    overflow: hidden;
  }
</style>

<script>
  $(document).ready(function() {
    // Initialize select2
    $('.select2').select2({
      placeholder: 'Chọn...',
      allowClear: false
    });

    // Handle form submission with loading state
    $('#aiGenerationForm').on('submit', function() {
      $('#generateBtn').addClass('d-none');
      $('#loadingBtn').removeClass('d-none');

      // Disable form inputs
      $(this).find('input, select, textarea, button').prop('disabled', true);
      $('#loadingBtn').prop('disabled', false);
    });

    // Handle question type radio button changes
    $('input[name="type"]').on('change', function() {
      // Remove active class from all cards
      $('.question-type-card .question-type-label').removeClass('active');

      // Add active class to selected card
      if ($(this).is(':checked')) {
        $(this).closest('.question-type-card').find('.question-type-label').addClass('active');
      }
    });

    // Handle clicking on question type cards (anywhere on the card)
    $('.question-type-card').on('click', function(e) {
      if (!$(e.target).is('input[type="radio"]')) {
        var radio = $(this).find('input[type="radio"]');
        radio.prop('checked', true).trigger('change');
      }
    });

    // Set initial active state for checked radio
    $('input[name="type"]:checked').trigger('change');
  });
</script>
@endsection