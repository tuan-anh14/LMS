<?php

namespace App\Http\Requests\Teacher;

use App\Enums\StudentExamStatusEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ExamAssignToClassRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    // Lấy danh sách examiner IDs hợp lệ
    $validExaminerIds = User::where('is_examiner', true)
      ->orWhereHas('roles', function ($query) {
        $query->where('name', 'examiner');
      })
      ->pluck('id')
      ->toArray();

    // Lấy teacher's section IDs để validate
    $teacherSectionIds = auth()->user()->teacherSections()
      ->wherePivot('center_id', session('selected_center')['id'])
      ->pluck('section_id')
      ->toArray();

    return [
      'section_id' => [
        'required',
        'exists:sections,id',
        'in:' . implode(',', $teacherSectionIds),
      ],
      'examiner_id' => [
        'required',
        'integer',
        'in:' . implode(',', $validExaminerIds),
      ],
      'date' => 'required|date|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
      'time' => 'required|date_format:H:i',
      'date_time' => 'required',
      'status' => 'required',
    ];
  }

  public function messages()
  {
    return [
      'section_id.in' => 'Bạn không có quyền giao bài cho lớp này.',
      'examiner_id.in' => 'Giám khảo được chọn không hợp lệ.',
      'date.after_or_equal' => 'Ngày thi không được là ngày trong quá khứ.',
      'date.date_format' => 'Định dạng ngày không hợp lệ (YYYY-MM-DD).',
      'time.date_format' => 'Định dạng thời gian không hợp lệ (HH:MM).',
    ];
  }

  public function prepareForValidation()
  {
    return $this->merge([
      'date_time' => $this->date . ' ' . $this->time,
      'status' => StudentExamStatusEnum::DATE_TIME_SET,
    ]);
  }
}
