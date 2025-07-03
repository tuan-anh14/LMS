<?php

namespace App\Http\Requests\Admin;

use App\Enums\GenderEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'country_id' => 'required|exists:countries,id',
            'governorate_id' => [
                'required',
                Rule::exists('governorates', 'id')->where('country_id', $this->country_id)
            ],
            'degree_id' => 'required|exists:degrees,id',
            'first_name' => 'required',
            'second_name' => 'required',
            'nickname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'mobile' => 'required|unique:users,mobile',
            'dob' => 'required|date_format:Y-m-d',
            'gender' => 'required|in:' . implode(',', [GenderEnum::MALE, GenderEnum::FEMALE]),
            'address' => 'required',
            'type' => 'required',
            'centers' => 'required|array|min:1',
            'centers.*.center' => 'required|exists:centers,id',
            'center_ids_as_manager' => 'sometimes|nullable|array|min:1',
            'center_ids_as_manager.*' => 'required_with:center_ids_as_manager|exists:centers,id',
            'is_examiner' => 'sometimes|nullable',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $teacher = $this->route()->parameter('teacher');

            $rules['email'] = 'required|email|unique:users,id,' . $teacher->id;
            $rules['mobile'] = 'required|unique:users,id,' . $teacher->id;
            $rules['password'] = 'sometimes|nullable';

        }//end of if

        return $rules;

    }//end of rules

    public function attributes()
    {
        return [
            'centers' => __('centers.centers')
        ];

    }// end of attributes

    public function prepareForValidation()
    {
        return $this->merge([
            'type' => UserTypeEnum::TEACHER,
            'is_examiner' => $this->is_examiner ? true : false,
        ]);

    }// end of prepareForValidation

}//end of request
