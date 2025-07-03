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
            'teachers_count' => 'required',
            'students_count' => 'required',
            'quran_we_ascend' => 'required',
            'convoy' => 'required',
            'pulpits_of_light' => 'required',
            'arabic_reading' => 'required',
            'holy_quran_teachers_cadres' => 'required',
            'licensed' => 'required',
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
