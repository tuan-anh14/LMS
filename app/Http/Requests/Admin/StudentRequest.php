<?php

namespace App\Http\Requests\Admin;

use App\Enums\GenderEnum;
use App\Enums\ReadingTypeEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'country_id' => 'required|exists:countries,id',
            'governorate_id' => [
                'required',
                Rule::exists('governorates', 'id')->where('country_id', $this->country_id)
            ],
            'first_name' => 'required',
            'second_name' => 'required',
            'nickname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'mobile' => 'required',
            'dob' => 'required|date_format:Y-m-d',
            'gender' => 'required|in:' . implode(',', GenderEnum::getConstants()),
            'address' => 'required',
            'reading_type' => 'required|in:' . implode(',', ReadingTypeEnum::getConstants()),
            'type' => 'required',
            'student_center_id' => 'required|exists:centers,id',
            'student_project_id' => 'required|exists:projects,id',
            'student_section_id' => 'required|exists:sections,id',
            'registration_date' => 'required|date_format:Y-m-d',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $student = $this->route()->parameter('student');

            $rules['email'] = 'required|email|unique:users,id,' . $student->id;
            $rules['mobile'] = 'required';
            $rules['password'] = 'sometimes|nullable';

        }//end of if

        return $rules;

    }//end of rules

    public function prepareForValidation()
    {
        return $this->merge([
            'type' => UserTypeEnum::STUDENT,
        ]);

    }// end of prepareForValidation

}//end of request
