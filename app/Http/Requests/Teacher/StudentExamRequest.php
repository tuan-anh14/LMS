<?php

namespace App\Http\Requests\Teacher;

use App\Enums\StudentExamStatusEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StudentExamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $student = User::query()
            ->where('id', $this->student_id)
            ->firstOrFail();

        // Lấy exam IDs mà giảng viên có thể tạo (thuộc projects họ dạy)
        /** @var \App\Models\User $teacher */
        $teacher = auth()->user();
        $teacherProjectIds = $teacher->getTeacherProjectIds(session('selected_center')['id']);
        
        // Lấy exams thuộc student project và thuộc teacher projects
        $availableExamIds = $student->studentProject->exams()
            ->whereIn('project_id', $teacherProjectIds)
            ->pluck('id')
            ->toArray();

        $rules = [
            'student_id' => 'required|integer|exists:users,id',
            'exam_id' => [
                'required', 
                'integer',
                'exists:exams,id',
                'in:' . implode(',', $availableExamIds),
            ],
            'examiner_id' => [
                'required', 'integer',
                'in:' . implode(',', User::where('is_examiner', true)->orWhereHas('roles', function($query) {
                    $query->where('name', 'examiner');
                })->pluck('id')->toArray()),
            ],
            'teacher_id' => 'required|exists:users,id',
            'center_id' => 'required|exists:centers,id',
            'section_id' => 'required|exists:sections,id',
            'project_id' => 'required|exists:projects,id',
            'status' => 'required'
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $studentExam = $this->route()->parameter('studentExam');

            $rules['student_id'] = 'sometimes|nullable';
            $rules['center_id'] = 'sometimes|nullable';
            $rules['section_id'] = 'sometimes|nullable';
            $rules['project_id'] = 'sometimes|nullable';
            $rules['status'] = 'sometimes|nullable';

        }//end of if

        return $rules;

    }//end of rules

    public function messages()
    {
        return [
            'exam_id.in' => 'Bạn chỉ có thể giao bài kiểm tra cho môn học mà bạn đang dạy và học sinh đang học.',
        ];
    }

    public function prepareForValidation()
    {
        $student = $this->student_id
            ? User::query()
                ->where('id', $this->student_id)
                ->firstOrFail()
            : null;

        $studentExam = $this->route()->parameter('studentExam');

        return $this->merge([
            'teacher_id' => auth()->user()->id,
            'center_id' => session('selected_center')['id'],
            'section_id' => $student ? $student->student_section_id : null,
            'project_id' => $student ? $student->student_project_id : null,
            'status' => StudentExamStatusEnum::ASSIGNED_TO_EXAMINER,
        ]);

    }// end of prepareForValidation

}//end of request
