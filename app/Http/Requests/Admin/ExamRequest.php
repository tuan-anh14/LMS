<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'project_id' => 'required|exists:projects,id',
            'name' => 'required',
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {

            $exam = $this->route()->parameter('exam');


        }//end of if

        return $rules;

    }//end of rules

}//end of request
