<?php

namespace App\Http\Requests\Teacher;

use App\Enums\AssessmentEnum;
use App\Enums\AttendanceStatusEnum;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentLectureRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'center_id' => 'required|exists:centers,id',
            'section_id' => 'required|exists:sections,id',
            'teacher_id' => 'required|exists:users,id',
            'student_id' => 'required|exists:users,id',
            'project_id' => 'required|exists:projects,id',
            'book_id' => 'required|exists:books,id',
            'lecture_id' => [
                'required',
                Rule::in(auth()->user()->teacherLectures()->pluck('id')->toArray()),
            ],
            'attendance_status' => 'required|in:' . implode(',', AttendanceStatusEnum::getConstants()),
            'pages' => 'required_if:attendance_status,' . AttendanceStatusEnum::ATTENDED . '|array|min:1',
            'pages.*.from' => 'required_if:attendance_status,' . AttendanceStatusEnum::ATTENDED . '|integer',
            'pages.*.to' => 'required_if:attendance_status,' . AttendanceStatusEnum::ATTENDED . '|integer|gte:pages.*.from',
            'pages.*.assessment' => 'required_if:attendance_status,' . AttendanceStatusEnum::ATTENDED . ' |in:' . implode(',', AssessmentEnum::getConstants()),
            'notes' => 'sometimes|nullable|string|max:255',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $studentLecture = $this->route()->parameter('studentLecture');

            $rules['student_id'] = 'sometimes|nullable';

        }//end of if

        return $rules;

    }//end of rules

    public function prepareForValidation()
    {
        $studentLecture = $this->route()->parameter('student_lecture');

        $isUpdateRequest = in_array($this->method(), ['PUT', 'PATCH']);

        $student = $studentLecture && $isUpdateRequest
            ? $studentLecture->student
            : User::query()
                ->where('id', $this->student_id)
                ->first();
        
        return $this->merge([
            'lecture_id' => $isUpdateRequest && $studentLecture ? $studentLecture->lecture_id : $this->lecture_id,
            'center_id' => session('selected_center')['id'],
            'section_id' => $student->student_section_id,
            'project_id' => $student->student_project_id,
            'book_id' => $student->studentProject->book_id,
            'teacher_id' => auth()->user()->id,
            'student_id' => $student->id,
        ]);

    }// end of prepareForValidation

}//end of request
