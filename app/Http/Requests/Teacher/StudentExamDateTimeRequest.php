<?php

namespace App\Http\Requests\Teacher;

use App\Enums\StudentExamStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class StudentExamDateTimeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'date' => 'required|date|date_format:Y-m-d|after_or_equal:' . date('Y-m-d'),
            'time' => 'required',
            'date_time' => 'required',
            'status' => 'required',
        ];

        return $rules;

    }//end of rules

    public function prepareForValidation()
    {

        return $this->merge([
            'date_time' => $this->date . ' ' . $this->time,
            'status' => StudentExamStatusEnum::DATE_TIME_SET,
        ]);

    }// end of prepareForValidation

}//end of request
