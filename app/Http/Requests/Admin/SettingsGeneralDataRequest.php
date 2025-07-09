<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingsGeneralDataRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'mobile' => 'required',
            'about_text' => 'required',
            'teachers_count' => 'nullable|numeric|min:0',
            'students_count' => 'nullable|numeric|min:0',
            'courses_count' => 'nullable|numeric|min:0',
            'certificates_count' => 'nullable|numeric|min:0',
            'success_rate' => 'nullable|numeric|min:0|max:100',
            'years_experience' => 'nullable|numeric|min:0',
            'total_graduates' => 'nullable|numeric|min:0',
            'active_students' => 'nullable|numeric|min:0',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $admin = $this->route()->parameter('admin');

            $rules['email'] = 'required|email|unique:users,id,' . $admin->id;
            $rules['password'] = '';

        }//end of if

        return $rules;

    }//end of rules

    protected function prepareForValidation()
    {
        return $this->merge([
            'type' => 'admin',
        ]);

    }//end of prepare for validation

}//end of request
